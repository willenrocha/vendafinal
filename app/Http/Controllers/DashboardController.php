<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\InstagramProfile;
use App\Models\Order;
use App\Models\UserCreditBalance;
use App\Services\Credits\CreditRedemptionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function index(Request $request): Response
    {
        $user = $request->user();

        // Buscar saldo de créditos do usuário
        $creditBalance = UserCreditBalance::firstOrCreate(
            ['user_id' => $user->id],
            ['likes' => 0, 'views' => 0, 'comments' => 0]
        );

        // Buscar todos os perfis do Instagram do usuário
        $instagramProfiles = \App\Models\InstagramProfile::where('user_id', $user->id)
            ->where('is_active', true)
            ->orderBy('last_synced_at', 'desc')
            ->get();

        // Determinar qual perfil exibir
        $profileId = $request->query('profile_id') ?? $request->session()->get('selected_profile_id');

        if ($profileId) {
            $instagramProfile = $instagramProfiles->firstWhere('id', $profileId);
            // Salvar escolha na sessão
            $request->session()->put('selected_profile_id', $profileId);
        } else {
            // Senão, pega o perfil principal (mais recente)
            $instagramProfile = $instagramProfiles->first();
            if ($instagramProfile) {
                $request->session()->put('selected_profile_id', $instagramProfile->id);
            }
        }

        // Buscar últimos posts do perfil (se existir)
        $recentPosts = [];
        if ($instagramProfile) {
            try {
                $recentPosts = $instagramProfile->getRecentPosts(9);
            } catch (\Exception $e) {
                // Se houver erro ao buscar posts, continua sem eles
                \Log::warning('Erro ao buscar posts do Instagram: ' . $e->getMessage());
                $recentPosts = [];
            }
        }

        // Buscar pedidos recentes do usuário
        $recentOrders = Order::where('user_id', $user->id)
            ->with(['package', 'instagramProfile'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($order) {
                return [
                    'id' => $order->id,
                    'public_code' => $order->public_code,
                    'package_name' => $order->package?->name ?? $order->package_snapshot['name'] ?? 'Pacote',
                    'instagram_username' => $order->instagram_username,
                    'amount' => number_format((float) $order->amount, 2, ',', '.'),
                    'status' => $order->status->value,
                    'status_label' => $order->status->label(),
                    'created_at' => $order->created_at->format('d/m/Y H:i'),
                    'created_at_human' => $order->created_at->diffForHumans(),
                ];
            });

        // Estatísticas
        $stats = [
            'total_orders' => Order::where('user_id', $user->id)->count(),
            'pending_orders' => Order::where('user_id', $user->id)
                ->whereIn('status', ['pending', 'processing'])
                ->count(),
            'completed_orders' => Order::where('user_id', $user->id)
                ->where('status', 'completed')
                ->count(),
            'total_spent' => Order::where('user_id', $user->id)
                ->where('status', 'paid')
                ->sum('amount'),
        ];

        return Inertia::render('Dashboard', [
            'user' => [
                'name' => $user->name,
                'email' => $user->email,
            ],
            'instagram_profiles' => $instagramProfiles->map(function ($profile) {
                return [
                    'id' => $profile->id,
                    'username' => $profile->username,
                    'full_name' => $profile->full_name,
                    'follower_count' => number_format((int) $profile->follower_count, 0, ',', '.'),
                    'media_count' => number_format((int) $profile->media_count, 0, ',', '.'),
                ];
            }),
            'instagram_profile' => $instagramProfile ? [
                'id' => $instagramProfile->id,
                'username' => $instagramProfile->username,
                'full_name' => $instagramProfile->full_name,
                'biography' => $instagramProfile->biography,
                'profile_pic' => $instagramProfile->getProfilePicProxied(),
                'follower_count' => number_format((int) $instagramProfile->follower_count, 0, ',', '.'),
                'following_count' => number_format((int) $instagramProfile->following_count, 0, ',', '.'),
                'media_count' => number_format((int) $instagramProfile->media_count, 0, ',', '.'),
                'is_verified' => $instagramProfile->is_verified,
            ] : null,
            'recent_posts' => $recentPosts,
            'credits' => [
                'likes' => (int) $creditBalance->likes,
                'views' => (int) $creditBalance->views,
                'comments' => (int) $creditBalance->comments,
            ],
            'recent_orders' => $recentOrders,
            'stats' => [
                'total_orders' => $stats['total_orders'],
                'pending_orders' => $stats['pending_orders'],
                'completed_orders' => $stats['completed_orders'],
                'total_spent' => 'R$ ' . number_format((float) $stats['total_spent'], 2, ',', '.'),
            ],
        ]);
    }

    public function orders(Request $request): Response
    {
        $user = $request->user();

        $query = Order::where('user_id', $user->id)
            ->with(['package', 'instagramProfile'])
            ->orderBy('created_at', 'desc');

        // Filtro por perfil
        $profileId = $request->query('profile_id');
        if ($profileId) {
            $query->where('instagram_profile_id', $profileId);
        }

        $orders = $query->paginate(15)->through(function ($order) {
            return [
                'id' => $order->id,
                'public_code' => $order->public_code,
                'package_name' => $order->package?->name ?? $order->package_snapshot['name'] ?? 'Pacote',
                'instagram_username' => $order->instagram_username,
                'amount' => number_format((float) $order->amount, 2, ',', '.'),
                'status' => $order->status->value,
                'status_label' => $order->status->label(),
                'created_at' => $order->created_at->format('d/m/Y H:i'),
                'created_at_human' => $order->created_at->diffForHumans(),
                'paid_at' => $order->paid_at?->format('d/m/Y H:i'),
            ];
        });

        $instagramProfiles = InstagramProfile::where('user_id', $user->id)
            ->where('is_active', true)
            ->get(['id', 'username']);

        return Inertia::render('Orders', [
            'orders' => $orders,
            'instagram_profiles' => $instagramProfiles,
            'filters' => [
                'profile_id' => $profileId ? (int) $profileId : null,
            ],
        ]);
    }

    public function redeemCredits(Request $request, CreditRedemptionService $redemptionService): JsonResponse
    {
        $validated = $request->validate([
            'post_id' => 'required|integer|exists:instagram_posts,id',
            'credit_type' => 'required|string|in:likes,views,comments',
            'amount' => 'required|integer|min:1',
        ]);

        $user = $request->user();
        $post = \App\Models\InstagramPost::findOrFail($validated['post_id']);

        // Verifica se o post pertence a um perfil do usuário
        $profile = InstagramProfile::where('id', $post->instagram_profile_id)
            ->where('user_id', $user->id)
            ->firstOrFail();

        try {
            $redemptionService->redeem(
                $user,
                $post,
                $validated['credit_type'],
                $validated['amount'],
            );
        } catch (\InvalidArgumentException $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao processar créditos. Tente novamente.'], 500);
        }

        // Retorna saldo atualizado
        $balance = UserCreditBalance::where('user_id', $user->id)->first();

        return response()->json([
            'message' => 'Créditos aplicados com sucesso!',
            'credits' => [
                'likes' => (int) ($balance->likes ?? 0),
                'views' => (int) ($balance->views ?? 0),
                'comments' => (int) ($balance->comments ?? 0),
            ],
        ]);
    }

    /**
     * Troca o perfil do Instagram selecionado
     */
    public function switchProfile(Request $request)
    {
        $profileId = $request->input('profile_id');

        // Verificar se o perfil pertence ao usuário
        $profile = \App\Models\InstagramProfile::where('id', $profileId)
            ->where('user_id', $request->user()->id)
            ->where('is_active', true)
            ->first();

        if ($profile) {
            $request->session()->put('selected_profile_id', $profileId);
        }

        return redirect()->route('dashboard');
    }
}
