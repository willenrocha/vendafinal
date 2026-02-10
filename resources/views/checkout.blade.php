<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>Checkout - {{ config('app.name', 'Laravel') }}</title>

  @vite(['resources/css/app.css', 'resources/js/app.js'])

  <style>
    @keyframes shimmer {
      0% { background-position: -1000px 0; }
      100% { background-position: 1000px 0; }
    }
    .animate-shimmer {
      animation: shimmer 2s infinite linear;
      background: linear-gradient(to right, #f3f4f6 0%, #e5e7eb 20%, #f3f4f6 40%, #f3f4f6 100%);
      background-size: 1000px 100%;
    }
    @keyframes pulse-border {
      0%, 100% { border-color: rgb(99 102 241 / 0.2); }
      50% { border-color: rgb(99 102 241 / 0.6); }
    }
    .animate-pulse-border {
      animation: pulse-border 2s ease-in-out infinite;
    }
  </style>
</head>

<body class="bg-gray-50 antialiased">
  @php
    $formatMoney = fn ($value) => 'R$ ' . number_format((float) $value, 2, ',', '.');

    $igPrivate = (bool) data_get($instagramProfile, 'is_private', false);
    $igProfile = (array) data_get($instagramProfile, 'profile', []);
    $igPic = (string) (data_get($igProfile, 'profile_pic_data_url') ?: data_get($igProfile, 'profile_pic_url', ''));
    $igFullName = (string) data_get($igProfile, 'full_name', '');
    $igUsername = (string) data_get($igProfile, 'username', $instagram);
    $igFollowers = (int) data_get($igProfile, 'follower_count', 0);
    $igFollowing = (int) data_get($igProfile, 'following_count', 0);
    $igVerified = (bool) data_get($igProfile, 'is_verified', false);
    $igBio = (string) data_get($igProfile, 'biography', '');

    $price = $formatMoney($package->price);
    $originalPrice = $package->original_price !== null ? $formatMoney($package->original_price) : null;
  @endphp

  <main class="min-h-screen bg-gradient-to-br from-indigo-50 via-purple-50 to-pink-50" data-initial-step="{{ $errors->any() ? 2 : 1 }}">
    <section class="relative overflow-hidden">
      <!-- Background decorativo -->
      <div class="absolute inset-0 overflow-hidden">
        <div class="absolute top-0 right-0 w-96 h-96 bg-indigo-200 rounded-full mix-blend-multiply filter blur-3xl opacity-40 animate-pulse"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-purple-200 rounded-full mix-blend-multiply filter blur-3xl opacity-40 animate-pulse" style="animation-delay: 2s;"></div>
      </div>

      <div class="relative max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10 lg:py-14">
        <!-- Header -->
        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
          <div>
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-white rounded-full shadow-md mb-4">
              <div class="w-2 h-2 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-full animate-pulse"></div>
              <span class="text-sm font-semibold text-gray-700">Checkout Seguro</span>
            </div>

            <h1 class="text-4xl sm:text-5xl font-extrabold text-gray-900 leading-tight">
              Finalize seu pedido
            </h1>
            <p class="text-lg text-gray-600 mt-2 max-w-2xl">
              Preencha seus dados e escolha o método de pagamento. É rápido e 100% seguro.
            </p>
          </div>

          <a href="/" class="hidden sm:inline-flex items-center gap-2 px-6 py-3 bg-white hover:bg-gray-50 rounded-xl text-gray-700 font-semibold shadow-lg transition">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Voltar
          </a>
        </div>

        <div class="grid lg:grid-cols-5 gap-8">
          <!-- Coluna Esquerda: Formulário de Pagamento -->
          <section id="payment" class="lg:col-span-3 bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-5">
              <h2 class="text-2xl font-bold text-white">Finalize agora</h2>
              <p class="text-purple-100 mt-1">Preencha os campos abaixo e gere o Pix</p>
            </div>

            <div class="p-6 sm:p-8">
              <form method="POST" action="{{ route('checkout.pix') }}" class="space-y-6" onsubmit="return false" novalidate>
              @csrf

              <div>
                <h3 class="text-sm font-extrabold text-gray-900">Preencha os campos abaixo:</h3>
              </div>

              <div>
                <label class="block text-sm font-semibold text-gray-800" for="name">Nome completo <span class="text-red-600">*</span></label>
                <div class="mt-2 flex items-center gap-3 rounded-full border-2 border-indigo-100 bg-white px-4 py-3 shadow-sm focus-within:ring-4 focus-within:ring-indigo-200/60">
                  <div class="w-10 h-10 rounded-full bg-indigo-50 text-indigo-700 flex items-center justify-center">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor"><path d="M12 12a5 5 0 1 0-5-5 5 5 0 0 0 5 5zm0 2c-4.33 0-8 2.17-8 5v1h16v-1c0-2.83-3.67-5-8-5z"/></svg>
                  </div>
                  <input id="name" name="name" type="text" autocomplete="name" value="{{ old('name') }}" placeholder="Seu nome completo" required class="w-full outline-none text-gray-900 placeholder:text-gray-400 bg-transparent" />
                </div>
                @error('name')
                  <p class="text-xs text-red-600 mt-2">{{ $message }}</p>
                @enderror
              </div>

              <div>
                <label class="block text-sm font-semibold text-gray-800" for="phone">Número de telefone (WhatsApp)</label>
                <div class="mt-2 flex items-center gap-3 rounded-full border-2 border-indigo-100 bg-white px-4 py-3 shadow-sm focus-within:ring-4 focus-within:ring-indigo-200/60">
                  <div class="w-10 h-10 rounded-full bg-purple-50 text-purple-700 flex items-center justify-center">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor"><path d="M6.62 10.79a15.05 15.05 0 0 0 6.59 6.59l2.2-2.2a1 1 0 0 1 1.01-.24 11.36 11.36 0 0 0 3.56.57 1 1 0 0 1 1 1V20a1 1 0 0 1-1 1A17 17 0 0 1 3 4a1 1 0 0 1 1-1h3.5a1 1 0 0 1 1 1 11.36 11.36 0 0 0 .57 3.56 1 1 0 0 1-.24 1.01l-2.21 2.22Z"/></svg>
                  </div>
                  <input id="phone" name="phone" type="text" inputmode="tel" autocomplete="tel" value="{{ old('phone') }}" placeholder="(DDD) 99999-9999" class="w-full outline-none text-gray-900 placeholder:text-gray-400 bg-transparent" />
                </div>
                @error('phone')
                  <p class="text-xs text-red-600 mt-2">{{ $message }}</p>
                @enderror
              </div>

              <div>
                <label class="block text-sm font-semibold text-gray-800" for="email">E-mail <span class="text-red-600">*</span></label>
                <div class="mt-2 flex items-center gap-3 rounded-full border-2 border-indigo-100 bg-white px-4 py-3 shadow-sm focus-within:ring-4 focus-within:ring-indigo-200/60">
                  <div class="w-10 h-10 rounded-full bg-indigo-50 text-indigo-700 flex items-center justify-center">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor"><path d="M20 4H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2Zm0 4-8 5-8-5V6l8 5 8-5v2Z"/></svg>
                  </div>
                  <input id="email" name="email" type="email" inputmode="email" autocomplete="email" value="{{ old('email') }}" placeholder="seu@email.com" required class="w-full outline-none text-gray-900 placeholder:text-gray-400 bg-transparent" />
                </div>
                @error('email')
                  <p class="text-xs text-red-600 mt-2">{{ $message }}</p>
                @enderror
              </div>

              <div class="rounded-2xl bg-gray-50 border border-gray-200 p-4">
                <p class="text-sm font-extrabold text-gray-900">Selecione a forma de pagamento:</p>
                <div class="mt-3 rounded-2xl border-2 border-indigo-200 bg-white px-5 py-4 flex items-center justify-between gap-4">
                  <div class="flex items-center gap-3">
                    <img src="{{ asset('images/logo-pix.png') }}" alt="Pix" class="h-6 w-auto" />
                    <div>
                      <p class="text-sm font-extrabold text-gray-900">Pix</p>
                      <p class="text-xs text-gray-600">QR Code + copia e cola</p>
                    </div>
                  </div>
                  <span class="text-xs font-bold text-indigo-700 bg-indigo-50 border border-indigo-200 rounded-full px-3 py-1">Disponível</span>
                </div>

                <div class="mt-4 flex items-center justify-between rounded-2xl bg-white border border-gray-200 px-4 py-3">
                  <p class="text-sm font-extrabold text-gray-900">Total</p>
                  <p class="text-lg font-extrabold text-gray-900">{{ $price }}</p>
                </div>

                  <button type="button" data-pix-generate class="mt-4 w-full bg-linear-to-r from-indigo-600 to-purple-600 text-white py-4 rounded-full font-extrabold text-lg hover:shadow-xl transition">
                  Gerar Pix
                </button>

                <div class="mt-4 hidden" data-pix-error></div>
              </div>
            </form>
            </div>
          </section>

          <!-- Coluna Direita: Resumo do Pedido -->
          <section class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
              <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-5">
                <h2 class="text-2xl font-bold text-white">Resumo do Pedido</h2>
              </div>

              <div class="p-6 space-y-6">
              <div class="p-6 space-y-6">
                @if (session('status'))
                  <div class="rounded-2xl bg-green-50 border border-green-200 px-4 py-3">
                    <div class="flex items-center gap-3">
                      <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                      </div>
                      <p class="text-sm font-semibold text-green-800">{{ session('status') }}</p>
                    </div>
                  </div>
                @endif

                <!-- Pacote Selecionado -->
                <div class="rounded-2xl bg-gradient-to-br from-indigo-50 to-purple-50 border-2 border-indigo-100 p-5">
                  <div class="space-y-4">
                    <!-- Cabeçalho -->
                    <div class="flex items-center gap-2">
                      <div class="w-10 h-10 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                      </div>
                      <span class="text-xs font-bold text-indigo-600 bg-indigo-100 px-3 py-1 rounded-full">PACOTE</span>
                    </div>

                    <!-- Informações -->
                    <div>
                      <h3 class="text-xl font-bold text-gray-900 leading-tight">{{ $package->name }}</h3>
                      <p class="text-sm text-gray-600 mt-2 flex items-center gap-2">
                        <svg class="w-4 h-4 text-purple-600 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                          <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                        </svg>
                        <span class="font-semibold truncate">{{ '@' . $instagram }}</span>
                      </p>
                    </div>

                    <!-- Preço -->
                    <div class="pt-4 border-t border-indigo-200/50">
                      <div class="flex items-end justify-between gap-4">
                        <div class="flex-1">
                          <p class="text-xs font-semibold text-gray-600">Valor Total</p>
                          @if ($originalPrice)
                            <p class="text-sm text-gray-400 line-through mt-1">{{ $originalPrice }}</p>
                          @endif
                        </div>
                        <div class="text-right">
                          <p class="text-3xl lg:text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600 whitespace-nowrap">{{ $price }}</p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

              @if ($instagramProfile)
                @if ($igPrivate)
                  <div class="mt-5 rounded-2xl bg-amber-50 border border-amber-200 p-4">
                    <p class="text-sm font-bold text-amber-900">Perfil privado</p>
                    <p class="text-sm text-amber-800 mt-1">
                      Você pode concluir o pagamento, mas o pedido só será processado quando o perfil estiver <span class="font-semibold">público</span>.
                    </p>
                  </div>
                @else
                  <div class="mt-5 rounded-2xl bg-indigo-50 border border-indigo-200 p-4">
                    <p class="text-sm font-bold text-indigo-900">Perfil validado</p>

                    <div class="mt-3 flex items-center gap-4">
                      <div class="w-14 h-14 rounded-2xl bg-white border border-indigo-100 overflow-hidden flex items-center justify-center">
                        @if ($igPic)
                          <img src="{{ $igPic }}" alt="Foto de perfil" class="w-full h-full object-cover" referrerpolicy="no-referrer" />
                        @else
                          <div class="w-full h-full bg-linear-to-br from-indigo-100 to-purple-100"></div>
                        @endif
                      </div>

                      <div class="min-w-0">
                        <p class="text-sm font-extrabold text-gray-900 truncate">
                          {{ $igFullName !== '' ? $igFullName : '@' . $igUsername }}
                          @if ($igVerified)
                            <span class="ml-1 inline-flex items-center rounded-full bg-indigo-600 text-white px-2 py-0.5 text-[10px] font-bold">Verificado</span>
                          @endif
                        </p>
                        <p class="text-sm text-gray-700 truncate"><span aria-hidden="true">@</span>{{ $igUsername }}</p>
                        <p class="text-xs text-gray-600 mt-1">{{ number_format($igFollowers, 0, ',', '.') }} seguidores • {{ number_format($igFollowing, 0, ',', '.') }} seguindo</p>
                      </div>
                    </div>

                    @if ($igBio !== '')
                      <p class="text-xs text-gray-700 mt-3 line-clamp-3">{{ $igBio }}</p>
                    @endif
                  </div>
                @endif
              @endif

              @php
                $bonusItems = $package->bonusItems ?? collect();
                $bonusItems = $bonusItems->where('is_active', true)->values();

                $bonusIcon = function (string $type): string {
                  return match ($type) {
                    'likes' => 'M12 21s-7.2-4.4-9.6-8.1C.4 10.3 1.6 7.7 4.3 6.9c1.6-.5 3.4 0 4.7 1.2C10.3 6.9 12 6 13.8 6.4c3.1.7 4.8 3.6 3.9 6.4C16.7 16.7 12 21 12 21z',
                    'views' => 'M12 5c-7 0-10 7-10 7s3 7 10 7 10-7 10-7-3-7-10-7zm0 12a5 5 0 1 1 0-10 5 5 0 0 1 0 10zm0-8a3 3 0 1 0 0 6 3 3 0 0 0 0-6z',
                    'comments' => 'M21 6a2 2 0 0 0-2-2H5A2 2 0 0 0 3 6v9a2 2 0 0 0 2 2h3v3l4-3h7a2 2 0 0 0 2-2V6z',
                    default => 'M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2zm1 14.5h-2V18h2v-1.5zM15 10.2l-.9.9A2.5 2.5 0 0 0 13 13.5V14h-2v-.7a4 4 0 0 1 1.3-3l1.1-1A1.5 1.5 0 1 0 11 8h-2a3.5 3.5 0 1 1 6 2.2z',
                  };
                };

                $bonusLabel = function ($bonus): string {
                  $label = (string) ($bonus->label ?? '');
                  if ($label !== '') return $label;

                  return match ((string) $bonus->credit_type) {
                    'likes' => 'Curtidas',
                    'views' => 'Visualizações',
                    'comments' => 'Comentários',
                    default => 'Bônus',
                  };
                };
              @endphp

              @if ($bonusItems->count() > 0)
                <details class="mt-5 rounded-2xl bg-white/70 border border-white shadow-sm p-4">
                  <summary class="cursor-pointer select-none list-none">
                    <div class="flex items-center justify-between gap-3">
                      <div>
                        <p class="text-sm font-extrabold text-gray-900">Bônus inclusos</p>
                        <p class="text-xs text-gray-600 mt-1">Você também recebe:</p>
                      </div>
                      <span class="text-xs font-bold text-indigo-700 bg-indigo-50 border border-indigo-200 rounded-full px-3 py-1">Ver</span>
                    </div>
                  </summary>

                  <div class="mt-4 grid gap-3">
                    @foreach ($bonusItems as $bonus)
                      <div class="flex items-start gap-3 rounded-2xl bg-gray-50 border border-gray-200 px-4 py-3">
                        <div class="w-9 h-9 rounded-xl bg-indigo-100 text-indigo-700 flex items-center justify-center">
                          <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                            <path d="{{ $bonusIcon((string) $bonus->credit_type) }}" />
                          </svg>
                        </div>
                        <div class="min-w-0">
                          <p class="text-sm font-bold text-gray-900">
                            {{ ($bonus->label ?? '') !== ''
                                ? (string) $bonus->label
                                : number_format((int) $bonus->amount, 0, ',', '.') . ' ' . $bonusLabel($bonus) }}
                          </p>
                          @if (!empty($bonus->subtitle))
                            <p class="text-xs text-gray-600 mt-0.5 truncate">{{ $bonus->subtitle }}</p>
                          @endif
                        </div>
                      </div>
                    @endforeach
                  </div>
                </details>
              @endif

              <div class="mt-6 grid gap-3">
                <div class="flex items-center gap-3 rounded-2xl bg-gray-50 border border-gray-200 px-4 py-3">
                  <div class="w-9 h-9 rounded-xl bg-indigo-100 text-indigo-700 flex items-center justify-center">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor"><path d="M12 1a5 5 0 0 0-5 5v4H6a2 2 0 0 0-2 2v7a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3v-7a2 2 0 0 0-2-2h-1V6a5 5 0 0 0-5-5Zm3 9H9V6a3 3 0 0 1 6 0v4Z"/></svg>
                  </div>
                  <div>
                    <p class="text-sm font-bold text-gray-900">Pagamento seguro</p>
                    <p class="text-xs text-gray-600">Suas informações ficam protegidas.</p>
                  </div>
                </div>

                <div class="flex items-center gap-3 rounded-2xl bg-gray-50 border border-gray-200 px-4 py-3">
                  <div class="w-9 h-9 rounded-xl bg-purple-100 text-purple-700 flex items-center justify-center">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor"><path d="M20 8h-3V6a5 5 0 0 0-10 0v2H4a2 2 0 0 0-2 2v9a3 3 0 0 0 3 3h14a3 3 0 0 0 3-3v-9a2 2 0 0 0-2-2Zm-11 0V6a3 3 0 0 1 6 0v2H9Z"/></svg>
                  </div>
                  <div>
                    <p class="text-sm font-bold text-gray-900">Confirmação</p>
                    <p class="text-xs text-gray-600">Você recebe o status do pedido.</p>
                  </div>
                </div>
              </div>
            </div>
          </section>
        </div>
      </div>
    </section>
  </main>

  <!-- Modal PIX com QR Code -->
  <div class="fixed inset-0 z-50 hidden items-center justify-center p-0 sm:p-4" data-pix-modal aria-hidden="true">
    <!-- Overlay -->
    <div class="absolute inset-0 bg-gray-900/80 backdrop-blur-md transition-opacity" data-pix-modal-close></div>

    <!-- Modal Content — mobile: fullscreen, desktop: centered card -->
    <div class="relative w-full h-full sm:h-auto sm:max-h-[95vh] sm:max-w-lg lg:max-w-3xl flex flex-col bg-white sm:rounded-3xl shadow-2xl overflow-hidden animate-fade-in-up">

      <!-- Header do Modal — compacto no mobile -->
      <div class="relative overflow-hidden bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-600 px-4 py-5 sm:px-6 sm:py-6">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-10">
          <div class="absolute inset-0" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 32px 32px;"></div>
        </div>

        <!-- Close button -->
        <button type="button" class="absolute top-3 right-3 sm:top-4 sm:right-4 z-10 w-10 h-10 sm:w-11 sm:h-11 rounded-full bg-white/15 hover:bg-white/25 backdrop-blur-sm flex items-center justify-center transition group" data-pix-modal-close aria-label="Fechar">
          <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white group-hover:scale-110 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>

        <div class="relative pr-12">
          <h3 class="text-xl sm:text-2xl font-extrabold text-white">
            Pague com Pix
          </h3>
          <p class="text-purple-100 text-sm mt-1 hidden sm:block">
            Escaneie o QR Code ou copie o código
          </p>
        </div>

        <!-- Info Cards — sempre lado a lado, compactos -->
        <div class="relative grid grid-cols-2 gap-3 mt-4">
          <div class="bg-white/15 backdrop-blur-sm rounded-xl px-3 py-2.5 sm:px-4 sm:py-3 border border-white/20">
            <p class="text-[11px] sm:text-xs font-medium text-purple-200 uppercase tracking-wide">Valor</p>
            <p class="text-lg sm:text-xl font-extrabold text-white mt-0.5 leading-tight">{{ $price }}</p>
          </div>
          <div class="bg-white/15 backdrop-blur-sm rounded-xl px-3 py-2.5 sm:px-4 sm:py-3 border border-white/20">
            <p class="text-[11px] sm:text-xs font-medium text-purple-200 uppercase tracking-wide">Tempo Limite</p>
            <p class="text-lg sm:text-xl font-extrabold text-white mt-0.5 leading-tight" data-pix-countdown>10:00</p>
          </div>
        </div>
      </div>

      <!-- Body do Modal — scroll no mobile -->
      <div class="flex-1 overflow-y-auto px-4 py-5 sm:px-6 sm:py-6 space-y-5">
        <div class="hidden" data-pix-error-modal></div>

        <!-- QR Code — centralizado, tamanho adaptável -->
        <div>
          <div class="flex items-center gap-2.5 mb-3">
            <div class="w-8 h-8 sm:w-9 sm:h-9 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-lg flex items-center justify-center flex-shrink-0">
              <span class="text-base sm:text-lg font-bold text-white">1</span>
            </div>
            <div>
              <h4 class="text-sm sm:text-base font-bold text-gray-900">Escaneie o QR Code</h4>
              <p class="text-xs text-gray-500">Abra o app do banco e escolha Pix</p>
            </div>
          </div>

          <div class="relative mx-auto w-full max-w-[240px] sm:max-w-[260px]">
            <div class="bg-white rounded-2xl border-2 border-gray-100 p-4 sm:p-5 flex items-center justify-center aspect-square shadow-lg" data-pix-qr>
              <div class="text-center">
                <div class="inline-flex w-12 h-12 bg-gray-100 rounded-xl items-center justify-center mb-2 animate-shimmer">
                  <svg class="w-6 h-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                  </svg>
                </div>
                <p class="text-xs font-medium text-gray-400">Gerando QR Code...</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Código Copia e Cola -->
        <div>
          <div class="flex items-center gap-2.5 mb-3">
            <div class="w-8 h-8 sm:w-9 sm:h-9 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-lg flex items-center justify-center flex-shrink-0">
              <span class="text-base sm:text-lg font-bold text-white">2</span>
            </div>
            <div>
              <h4 class="text-sm sm:text-base font-bold text-gray-900">Ou copie o código</h4>
              <p class="text-xs text-gray-500">Cole no app do seu banco</p>
            </div>
          </div>

          <div class="bg-gray-50 rounded-xl border border-gray-200 p-3 sm:p-4">
            <textarea readonly rows="3"
                      class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-[11px] sm:text-xs text-gray-900 font-mono leading-relaxed focus:outline-none focus:ring-2 focus:ring-indigo-500 resize-none"
                      data-pix-brcode
                      placeholder="O código Pix aparecerá aqui..."></textarea>

            <button type="button" data-pix-copy
                    class="mt-2.5 w-full group flex items-center justify-center gap-2.5 px-4 py-3 sm:py-3.5 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 rounded-xl text-white font-bold text-sm sm:text-base shadow-lg hover:shadow-xl transition-all active:scale-[0.98]">
              <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
              </svg>
              <span>Copiar Código Pix</span>
            </button>
          </div>
        </div>

        <!-- Status de Verificação -->
        <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl border border-blue-100 p-3.5 sm:p-4">
          <div class="flex items-center gap-3">
            <div class="flex-shrink-0">
              <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-white animate-spin" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
              </div>
            </div>
            <div class="flex-1 min-w-0">
              <h5 class="text-sm font-bold text-blue-900">Aguardando Pagamento</h5>
              <p class="text-xs text-blue-700 mt-0.5">Confirmaremos automaticamente assim que você pagar.</p>
              <p class="text-[11px] text-blue-500 font-medium mt-1" data-pix-checking>Verificando a cada 7s...</p>
            </div>
          </div>
        </div>

        <!-- Dica -->
        <div class="bg-gradient-to-r from-purple-50 to-pink-50 rounded-xl border border-purple-100 p-3.5 sm:p-4">
          <div class="flex items-start gap-3">
            <div class="w-8 h-8 bg-purple-500 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
              <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
            </div>
            <p class="text-xs sm:text-sm text-purple-700">Pague dentro do tempo limite para garantir processamento imediato. Você receberá confirmação por e-mail.</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    (() => {
      const form = document.querySelector('form[action="{{ route('checkout.pix') }}"]');
      if (!form) return;

      const pixModal = document.querySelector('[data-pix-modal]');
      const pixModalClosers = Array.from(document.querySelectorAll('[data-pix-modal-close]'));
      const pixCountdown = document.querySelector('[data-pix-countdown]');

      const pixGenerateBtn = document.querySelector('[data-pix-generate]');
      const pixQr = document.querySelector('[data-pix-qr]');
      const pixBrcode = document.querySelector('[data-pix-brcode]');
      const pixCopyBtn = document.querySelector('[data-pix-copy]');
      const pixError = document.querySelector('[data-pix-error]');

      const pixCheckingHint = document.querySelector('[data-pix-checking]');

      const pixErrorModal = document.querySelector('[data-pix-error-modal]');

      let countdownTimer = null;
      let countdownEndsAt = null;

      let statusPollTimer = null;

      const csrfToken = () => {
        const meta = document.querySelector('meta[name="csrf-token"]');
        if (meta && meta.content) return meta.content;
        const input = document.querySelector('input[name="_token"]');
        return input ? input.value : '';
      };

      const showPixError = (html) => {
        if (!pixError) return;
        if (!html) {
          pixError.classList.add('hidden');
          pixError.innerHTML = '';
          return;
        }
        pixError.className = 'mt-4 rounded-2xl bg-red-50 border border-red-200 text-red-800 px-4 py-3 text-sm';
        pixError.innerHTML = html;
        pixError.classList.remove('hidden');
      };

      const showPixErrorModal = (html) => {
        if (!pixErrorModal) return;
        if (!html) {
          pixErrorModal.classList.add('hidden');
          pixErrorModal.innerHTML = '';
          return;
        }
        pixErrorModal.className = 'mb-4 rounded-2xl bg-red-50 border border-red-200 text-red-800 px-4 py-3 text-sm';
        pixErrorModal.innerHTML = html;
        pixErrorModal.classList.remove('hidden');
      };

      const openPixModal = () => {
        if (!pixModal) return;
        pixModal.classList.remove('hidden');
        pixModal.classList.add('flex');
        pixModal.setAttribute('aria-hidden', 'false');
        document.documentElement.classList.add('overflow-hidden');

        // Se o Pix já foi gerado (textarea preenchida), continua verificando automaticamente.
        if (pixBrcode && (pixBrcode.value || '').trim() !== '') {
          if (pixCheckingHint) pixCheckingHint.classList.remove('hidden');
          startStatusPolling();
        }
      };

      const closePixModal = () => {
        if (!pixModal) return;
        pixModal.classList.add('hidden');
        pixModal.classList.remove('flex');
        pixModal.setAttribute('aria-hidden', 'true');
        document.documentElement.classList.remove('overflow-hidden');

        if (countdownTimer) {
          clearInterval(countdownTimer);
          countdownTimer = null;
        }

        if (statusPollTimer) {
          clearInterval(statusPollTimer);
          statusPollTimer = null;
        }

        if (pixCheckingHint) {
          pixCheckingHint.classList.add('hidden');
        }
      };

      const setChecking = (isChecking) => {
        if (!pixCheckingHint) return;
        if (isChecking) pixCheckingHint.classList.remove('hidden');
        else pixCheckingHint.classList.add('hidden');
      };

      const checkPaymentStatus = async () => {
        setChecking(true);
        try {
          const res = await fetch('{{ route('checkout.status') }}', {
            method: 'POST',
            headers: {
              'X-CSRF-TOKEN': csrfToken(),
              'Accept': 'application/json',
              'Content-Type': 'application/json',
            },
            body: JSON.stringify({}),
          });

          const json = await res.json().catch(() => ({}));
          if (!res.ok) {
            const msg = json.message || 'Não foi possível verificar o pagamento agora.';
            showPixErrorModal(msg);
            return false;
          }

          if ((json.status || '') === 'paid') {
            window.location.href = '{{ route('checkout.success') }}';
            return true;
          }

          // Mantém uma mensagem leve (sem CTA).
          showPixErrorModal('Aguardando confirmação do pagamento. Isso pode levar alguns instantes.');
          return false;
        } catch {
          showPixErrorModal('Não foi possível verificar o pagamento agora. Tente novamente.');
          return false;
        } finally {
          setChecking(false);
        }
      };

      const startStatusPolling = () => {
        if (statusPollTimer) {
          clearInterval(statusPollTimer);
          statusPollTimer = null;
        }

        statusPollTimer = setInterval(() => {
          // Evita flood se o usuário fechou o modal.
          if (!pixModal || pixModal.classList.contains('hidden')) return;
          checkPaymentStatus();
        }, 7000);
      };

      const startCountdown = (seconds) => {
        if (!pixCountdown) return;

        if (countdownTimer) {
          clearInterval(countdownTimer);
          countdownTimer = null;
        }

        countdownEndsAt = Date.now() + seconds * 1000;

        const tick = () => {
          const remaining = Math.max(0, Math.ceil((countdownEndsAt - Date.now()) / 1000));
          const mm = String(Math.floor(remaining / 60)).padStart(2, '0');
          const ss = String(remaining % 60).padStart(2, '0');
          pixCountdown.textContent = `${mm}:${ss}`;
        };

        tick();
        countdownTimer = setInterval(tick, 1000);
      };

      const generatePix = async () => {
        if (!pixGenerateBtn || !pixQr || !pixBrcode) return;
        showPixError('');
        showPixErrorModal('');

        if ((pixBrcode.value || '').trim() !== '') {
          openPixModal();
          return;
        }

        const name = form.querySelector('#name');
        const email = form.querySelector('#email');
        if (name) name.required = true;
        if (email) email.required = true;
        if (!form.checkValidity()) {
          form.reportValidity();
          return;
        }

        pixGenerateBtn.disabled = true;
        pixGenerateBtn.textContent = 'Gerando...';

        if (pixQr) {
          pixQr.innerHTML = '<div class="text-center"><div class="inline-flex w-16 h-16 bg-gray-100 rounded-2xl items-center justify-center mb-3 animate-shimmer"><svg class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" /></svg></div><p class="text-sm font-medium text-gray-500">Gerando QR Code...</p></div>';
        }

        openPixModal();
        startCountdown(10 * 60);

        try {
          const payload = new FormData(form || undefined);
          const res = await fetch('{{ route('checkout.pix') }}', {
            method: 'POST',
            headers: {
              'X-CSRF-TOKEN': csrfToken(),
              'Accept': 'application/json',
            },
            body: payload,
          });

          const json = await res.json().catch(() => ({}));
          if (!res.ok) {
            const errors = json.errors || null;
            if (errors) {
              const items = Object.values(errors).flat().map((m) => `<li>${m}</li>`).join('');
              const html = `<p class="font-semibold">Não foi possível gerar o Pix:</p><ul class="mt-2 list-disc list-inside">${items}</ul>`;
              showPixError(html);
              showPixErrorModal(html);
            } else {
              const msg = json.message || 'Não foi possível gerar o Pix agora.';
              showPixError(msg);
              showPixErrorModal(msg);
            }
            return;
          }

          pixQr.innerHTML = json.qr_svg || '<div class="text-center"><p class="text-sm font-medium text-gray-500">QR Code indisponível</p></div>';
          pixBrcode.value = json.brcode || '';

          // Começa a verificar periodicamente; quando aprovar, redireciona.
          startStatusPolling();
        } catch (e) {
          const msg = 'Não foi possível gerar o Pix agora. Tente novamente.';
          showPixError(msg);
          showPixErrorModal(msg);
        } finally {
          pixGenerateBtn.disabled = false;
          pixGenerateBtn.textContent = 'Gerar Pix';
        }
      };

      pixModalClosers.forEach((btn) => btn.addEventListener('click', closePixModal));
      document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closePixModal();
      });

      if (pixGenerateBtn) {
        pixGenerateBtn.addEventListener('click', generatePix);
      }

      if (pixCopyBtn && pixBrcode) {
        pixCopyBtn.addEventListener('click', async () => {
          const text = (pixBrcode.value || '').trim();
          if (!text) return;
          try {
            await navigator.clipboard.writeText(text);
            pixCopyBtn.innerHTML = '<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg><span>Copiado!</span>';
            setTimeout(() => {
              pixCopyBtn.innerHTML = '<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" /></svg><span>Copiar Código Pix</span>';
            }, 2000);
          } catch {
            pixBrcode.focus();
            pixBrcode.select();
          }
        });
      }

    })();
  </script>
</body>

</html>
