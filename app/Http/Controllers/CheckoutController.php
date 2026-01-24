<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Models\Package;
use App\Notifications\OrderAwaitingPaymentNotification;
use App\Services\Instagram\HikerApiClient;
use App\Services\Payment\ExpayService;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Notification;
use Illuminate\View\View;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class CheckoutController
{
    public function show(Request $request): View|RedirectResponse
    {
        $packageId = (int) $request->session()->get('checkout.package_id', 0);
        $instagram = (string) $request->session()->get('checkout.instagram', '');
        $instagramProfile = $request->session()->get('checkout.instagram_profile');

        if ($packageId <= 0 || $instagram === '') {
            return redirect('/');
        }

        $package = Package::query()
            ->with([
                'bonusItems' => fn ($query) => $query->where('is_active', true)->orderBy('id'),
            ])
            ->whereKey($packageId)
            ->where('is_active', true)
            ->first();

        if (! $package) {
            return redirect('/');
        }

        return view('checkout', [
            'package' => $package,
            'instagram' => $instagram,
            'instagramProfile' => $instagramProfile,
        ]);
    }

    public function success(Request $request): View|RedirectResponse
    {
        $orderPublicId = (string) $request->session()->get('checkout.order_public_id', '');
        $orderId = (int) $request->session()->get('checkout.order_id', 0);

        if ($orderPublicId === '' && $orderId <= 0) {
            return redirect()->route('checkout.show');
        }

        $order = Order::query()
            ->with('package')
            ->when($orderPublicId !== '', fn ($q) => $q->where('public_id', $orderPublicId))
            ->when($orderPublicId === '' && $orderId > 0, fn ($q) => $q->whereKey($orderId))
            ->first();

        if (! $order) {
            return redirect()->route('checkout.show');
        }

        $statusValue = $order->status instanceof OrderStatus ? $order->status->value : (string) $order->status;
        if ($statusValue !== OrderStatus::Paid->value) {
            return redirect()->route('checkout.show')->with('status', 'Aguardando a confirmação do pagamento.');
        }

        return view('checkout-success', [
            'order' => $order,
            'package' => $order->package,
        ]);
    }

    public function start(Request $request, HikerApiClient $client): RedirectResponse
    {
        $data = $request->validate([
            'package_id' => ['required', 'integer', 'min:1', 'exists:packages,id'],
            'instagram' => ['required', 'string', 'min:3', 'max:30', 'regex:/^[A-Za-z0-9._]+$/'],
        ], [
            'instagram.regex' => 'Informe um @ válido (sem @, sem espaços).',
        ]);

        $package = Package::query()
            ->whereKey((int) $data['package_id'])
            ->where('is_active', true)
            ->first();

        if (! $package) {
            return redirect('/');
        }

        $username = (string) $data['instagram'];
        $username = trim($username);
        $username = ltrim($username, '@');

        try {
            $result = Cache::remember(
                'hikerapi:username:' . strtolower($username),
                now()->addMinutes(10),
                fn () => $client->lookupByUsername($username),
            );

            if (! ($result['exists'] ?? false)) {
                return back()->withErrors([
                    'instagram' => 'Esse perfil não foi encontrado. Verifique o @ e tente novamente.',
                ])->withInput();
            }

            $request->session()->put('checkout.instagram_profile', [
                'checked_at' => now()->toIso8601String(),
                'is_private' => (bool) ($result['is_private'] ?? false),
                'profile' => (function () use ($result) {
                    $profile = (array) ($result['profile'] ?? []);

                    $picUrl = (string) ($profile['profile_pic_url'] ?? '');
                    if ($picUrl !== '') {
                        $dataUrl = Cache::remember(
                            'ig:pic:dataurl:' . md5($picUrl),
                            now()->addMinutes(30),
                            fn () => $this->downloadImageAsDataUrl($picUrl),
                        );

                        if (is_string($dataUrl) && $dataUrl !== '') {
                            $profile['profile_pic_data_url'] = $dataUrl;
                        }
                    }

                    return $profile;
                })(),
            ]);
        } catch (\Throwable $e) {
            report($e);

            return back()->withErrors([
                'instagram' => 'Não foi possível validar o Instagram agora. Tente novamente em instantes.',
            ])->withInput();
        }

        $request->session()->put('checkout.package_id', (int) $data['package_id']);
        $request->session()->put('checkout.instagram', $username);

        return redirect()->route('checkout.show');
    }

    public function submit(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:190'],
            'phone' => ['nullable', 'string', 'max:30'],
        ]);

        // Placeholder para integração com CRM.
        logger()->info('checkout.submitted', [
            'package_id' => $request->session()->get('checkout.package_id'),
            'instagram' => $request->session()->get('checkout.instagram'),
            'instagram_profile' => $request->session()->get('checkout.instagram_profile'),
            'data' => $data,
            'ip' => $request->ip(),
            'user_agent' => (string) $request->userAgent(),
        ]);

        return redirect()->route('checkout.show')->with('status', 'Dados enviados! Em breve vamos integrar ao CRM.');
    }

    public function pix(Request $request): JsonResponse
    {
        $packageId = (int) $request->session()->get('checkout.package_id', 0);
        $instagram = (string) $request->session()->get('checkout.instagram', '');

        if ($packageId <= 0 || $instagram === '') {
            return response()->json([
                'message' => 'Checkout inválido. Volte e tente novamente.',
            ], 422);
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:190'],
            'phone' => ['nullable', 'string', 'max:30'],
        ]);

        $request->session()->put('checkout.customer', $data);

        $package = Package::query()
            ->whereKey($packageId)
            ->where('is_active', true)
            ->first();

        if (! $package) {
            return response()->json([
                'message' => 'Pacote inválido. Volte e tente novamente.',
            ], 422);
        }

        // Busca ou cria usuário
        $user = \App\Models\User::query()
            ->where('email', strtolower(trim($data['email'])))
            ->where('is_admin', false)
            ->first();

        // Se usuário não existe, cria e salva para ter um ID válido
        if (!$user) {
            $user = \App\Models\User::create([
                'name' => $data['name'],
                'email' => strtolower(trim($data['email'])),
                'password' => \Illuminate\Support\Facades\Hash::make(\Illuminate\Support\Str::random(32)),
                'is_admin' => false,
            ]);
        }

        // Busca ou cria perfil do Instagram
        $instagramProfile = \App\Models\InstagramProfile::findOrCreateForUser(
            user: $user,
            username: $instagram,
            profileData: $request->session()->get('checkout.instagram_profile')
        );

        // Busca ou cria pedido pendente único (evita duplicação)
        $resultOrder = Order::findOrCreatePendingOrder(
            customerEmail: (string) $data['email'],
            packageId: (int) $package->id,
            customerName: (string) $data['name'],
            amount: (string) $package->price,
            instagramProfileId: (int) $instagramProfile->id,
            instagramUsername: $instagram
        );

        $order = $resultOrder['order'];
        $wasNewOrder = $resultOrder['wasNew'];

        // Atualiza dados do cliente
        $order->fill([
            'customer_name' => (string) $data['name'],
            'customer_email' => (string) $data['email'],
            'customer_phone' => $data['phone'] ?? null,
            'instagram_profile_id' => (int) $instagramProfile->id,
            'instagram_username' => $instagram,
            'instagram_profile' => $request->session()->get('checkout.instagram_profile'),
            'package_snapshot' => [
                'id' => (int) $package->id,
                'name' => (string) $package->name,
                'price' => (string) $package->price,
                'original_price' => $package->original_price ? (string) $package->original_price : null,
            ],
            'amount' => $package->price,
            'currency' => 'BRL',
        ]);

        $order->save();

        // Gera PIX via Expay
        try {
            $expayService = new ExpayService();
            $pixData = $expayService->createPixCharge($order);

            $brCode = $pixData['brcode'];
            $qrCodeBase64 = $pixData['qrcode_base64'] ?? null;
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 422);
        }

        $request->session()->put('checkout.order_id', (int) $order->id);
        $request->session()->put('checkout.order_public_id', (string) ($order->public_id ?? ''));
        $request->session()->put('checkout.order_public_code', (string) ($order->public_code ?? ''));

        // Envia e-mail apenas na primeira vez (evita spam se regenerar Pix)
        if ($wasNewOrder || $order->email_sent_at === null) {
            Notification::route('mail', (string) $order->customer_email)
                ->notify(new OrderAwaitingPaymentNotification($order));

            $order->email_sent_at = now();
            $order->save();
        }

        // Gera QR Code SVG a partir do brcode
        // Se a Expay já retornou base64, podemos usar; senão geramos localmente
        if ($qrCodeBase64) {
            $qrSvg = '<img src="data:image/png;base64,' . $qrCodeBase64 . '" alt="QR Code PIX" />';
        } else {
            $qrSvg = QrCode::format('svg')
                ->size(240)
                ->margin(1)
                ->generate($brCode);
        }

        logger()->info('checkout.pix.generated', [
            'package_id' => $packageId,
            'instagram' => $instagram,
            'email' => $data['email'] ?? null,
        ]);

        return response()->json([
            'brcode' => $brCode,
            'qr_svg' => $qrSvg,
        ]);
    }

    public function status(Request $request): JsonResponse
    {
        $orderPublicId = (string) $request->session()->get('checkout.order_public_id', '');
        $orderId = (int) $request->session()->get('checkout.order_id', 0);

        if ($orderPublicId === '' && $orderId <= 0) {
            return response()->json([
                'status' => null,
                'message' => 'Nenhum pedido encontrado para este checkout.',
            ], 404);
        }

        $order = Order::query()
            ->when($orderPublicId !== '', fn ($q) => $q->where('public_id', $orderPublicId))
            ->when($orderPublicId === '' && $orderId > 0, fn ($q) => $q->whereKey($orderId))
            ->first();
        if (! $order) {
            return response()->json([
                'status' => null,
                'message' => 'Pedido não encontrado.',
            ], 404);
        }

        $statusValue = $order->status instanceof OrderStatus ? $order->status->value : (string) $order->status;

        return response()->json([
            'order' => [
                'id' => (int) $order->id,
                'public_id' => (string) ($order->public_id ?? ''),
                'public_code' => (string) ($order->public_code ?? ''),
            ],
            'status' => $statusValue,
            'paid_at' => $order->paid_at?->toIso8601String(),
        ]);
    }

    private function downloadImageAsDataUrl(string $url): ?string
    {
        $parts = parse_url($url);
        if (!is_array($parts)) {
            return null;
        }

        $scheme = (string) ($parts['scheme'] ?? '');
        $host = (string) ($parts['host'] ?? '');

        if ($scheme !== 'https' || $host === '') {
            return null;
        }

        $allowedHosts = [
            'cdninstagram.com',
            'fbcdn.net',
            'instagram.com',
        ];

        $allowed = false;
        foreach ($allowedHosts as $suffix) {
            if ($host === $suffix || str_ends_with($host, '.' . $suffix)) {
                $allowed = true;
                break;
            }
        }

        if (! $allowed) {
            return null;
        }

        try {
            $response = Http::timeout(12)
                ->withHeaders([
                    'Accept' => 'image/*',
                ])
                ->get($url);

            $response->throw();

            $contentType = (string) ($response->header('Content-Type') ?? '');
            $mime = str_contains($contentType, ';') ? trim(explode(';', $contentType, 2)[0]) : trim($contentType);
            if ($mime === '') {
                $mime = 'image/jpeg';
            }

            $bytes = (string) $response->body();
            if ($bytes === '') {
                return null;
            }

            // Limite de segurança para evitar estourar payload/session.
            if (strlen($bytes) > 1024 * 1024) {
                return null;
            }

            return 'data:' . $mime . ';base64,' . base64_encode($bytes);
        } catch (RequestException) {
            return null;
        } catch (\Throwable) {
            return null;
        }
    }
}
