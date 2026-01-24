<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Pacotes - {{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="bg-gray-50 font-inter">

  <!-- Navbar Principal -->
  <nav class="bg-white shadow-sm sticky top-0 z-50">
    <!-- Banner de Confiança -->
    <div class="bg-gradient-to-r from-green-500 to-green-600 text-white py-2">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-center space-x-2">
          <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
          </svg>
          <span class="font-bold text-sm uppercase tracking-wide">Compra 100% Segura</span>
        </div>
      </div>
    </div>

    <!-- Barra de Benefícios -->
    <div class="border-b border-gray-200 bg-white py-3">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-wrap items-center justify-center gap-4 sm:gap-6 lg:gap-8 text-xs sm:text-sm">

          <!-- Compra Segura -->
          <div class="flex items-center space-x-2 text-gray-700">
            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
            </svg>
            <span class="font-medium">Compra segura</span>
          </div>

          <!-- Sigilo Total -->
          <div class="flex items-center space-x-2 text-gray-700">
            <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
            </svg>
            <span class="font-medium">Sigilo total</span>
          </div>

          <!-- Avaliação -->
          <div class="flex items-center space-x-2 text-gray-700">
            <svg class="w-4 h-4 text-yellow-500" fill="currentColor" viewBox="0 0 24 24">
              <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
            </svg>
            <span class="font-medium">Nota <span class="text-yellow-600 font-bold">4,87</span> dos consumidores</span>
          </div>

        </div>
      </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center h-20">

        <!-- Logo -->
        <div class="flex-shrink-0">
          <a href="/" class="flex items-center space-x-2">
            <img src="{{ asset('/images/logo.svg') }}" alt="Turbo Digital" class="md:h-16 h-12 w-auto">
          </a>
        </div>

        <!-- Menu Desktop -->
        <div class="hidden md:flex items-center space-x-8">
          <a href="/#como-funciona" class="text-gray-700 hover:text-indigo-600 font-medium transition">
            Como Funciona
          </a>
          <a href="/#pacotes" class="text-gray-700 hover:text-indigo-600 font-medium transition">
            Pacotes
          </a>
          <a href="/#duvidas" class="text-gray-700 hover:text-indigo-600 font-medium transition">
            Dúvidas
          </a>
          <a href="/#suporte" class="text-gray-700 hover:text-indigo-600 font-medium transition">
            Suporte
          </a>
        </div>

        <!-- CTAs Desktop -->
        <div class="hidden md:flex items-center space-x-4">
          <a href="#login" class="flex items-center space-x-2 text-gray-700 hover:text-indigo-600 font-medium transition">
            <span>Entrar</span>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
          </a>
        </div>

        <!-- Mobile Menu Button -->
        <div class="md:hidden">
          <button id="mobile-menu-btn" type="button" class="text-gray-700 hover:text-indigo-600 focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
          </button>
        </div>
      </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="hidden md:hidden bg-white border-t border-gray-200">
      <div class="px-4 py-4 space-y-2">
        <a href="/#como-funciona" class="block px-4 py-2 text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 rounded-lg transition">
          Como Funciona
        </a>
        <a href="/#pacotes" class="block px-4 py-2 text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 rounded-lg transition">
          Pacotes
        </a>
        <a href="/#duvidas" class="block px-4 py-2 text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 rounded-lg transition">
          Dúvidas
        </a>
        <a href="/#suporte" class="block px-4 py-2 text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 rounded-lg transition">
          Suporte
        </a>
        <a href="#login" class="block px-4 py-2 text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 rounded-lg transition">
          Entrar
        </a>
      </div>
    </div>
  </nav>

  <!-- Hero Section -->
  <section class="py-12 lg:py-16 bg-gradient-to-br from-indigo-600 via-purple-600 to-indigo-700 relative overflow-hidden">
    <div class="absolute inset-0 bg-[linear-gradient(rgba(255,255,255,0.05)_1px,transparent_1px),linear-gradient(90deg,rgba(255,255,255,0.05)_1px,transparent_1px)] bg-[size:50px_50px]"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
      <div class="text-center">
        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-white mb-6">
          Escolha seu <span class="text-yellow-300">Pacote Ideal</span>
        </h1>
        <p class="text-xl text-indigo-100 max-w-3xl mx-auto">
          Turbine suas redes sociais com nossos pacotes completos. Entrega rápida e resultados garantidos!
        </p>
      </div>
    </div>
  </section>

  <!-- Seção de Pacotes por Categoria -->
  <section class="py-16 lg:py-24 bg-gradient-to-br from-gray-50 to-indigo-50 relative overflow-hidden">
    <!-- Decorações de fundo -->
    <div class="absolute top-20 right-0 w-72 h-72 bg-purple-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob"></div>
    <div class="absolute bottom-20 left-0 w-72 h-72 bg-indigo-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">

      @php
        $formatAmount = function ($value) {
            if ($value === null) {
                return null;
            }
            $value = (int) $value;

            if ($value >= 1000000) {
                $formatted = number_format($value / 1000000, 1, '.', '');
                $formatted = rtrim(rtrim($formatted, '0'), '.');
                return $formatted . 'M';
            }

            if ($value >= 1000) {
                $formatted = number_format($value / 1000, 1, '.', '');
                $formatted = rtrim(rtrim($formatted, '0'), '.');
                return $formatted . 'K';
            }

            return number_format($value, 0, ',', '.');
        };

        $formatMoney = function ($value) {
            if ($value === null) {
                return null;
            }
            return number_format((float) $value, 0, ',', '.');
        };

        $variants = [
          [
            'header' => 'from-gray-100 to-gray-200',
            'cta' => 'from-gray-600 to-gray-700',
            'body' => 'from-white to-gray-50/30',
          ],
          [
            'header' => 'from-blue-100 to-indigo-200',
            'cta' => 'from-indigo-600 to-indigo-700',
            'body' => 'from-white to-indigo-50/20',
          ],
          [
            'header' => 'from-amber-100 to-orange-200',
            'cta' => 'from-amber-600 to-orange-600',
            'body' => 'from-white to-orange-50/20',
          ],
          [
            'header' => 'from-slate-100 to-slate-200',
            'cta' => 'from-slate-600 to-slate-700',
            'body' => 'from-white to-slate-50/20',
          ],
          [
            'header' => 'from-yellow-100 to-yellow-200',
            'cta' => 'from-yellow-600 to-yellow-700',
            'body' => 'from-white to-yellow-50/20',
          ],
          [
            'header' => 'from-cyan-100 to-cyan-200',
            'cta' => 'from-cyan-600 to-cyan-700',
            'body' => 'from-white to-cyan-50/20',
          ],
          [
            'header' => 'from-sky-100 to-blue-200',
            'cta' => 'from-blue-600 to-blue-700',
            'body' => 'from-white to-blue-50/20',
          ],
          [
            'header' => 'from-violet-100 to-purple-200',
            'cta' => 'from-purple-600 to-purple-700',
            'body' => 'from-white to-purple-50/20',
          ],
          [
            'header' => 'from-rose-100 to-pink-200',
            'cta' => 'from-rose-600 to-pink-600',
            'body' => 'from-white to-pink-50/20',
          ],
        ];

        // Ícones para cada rede social
        $socialIcons = [
          'Instagram' => '<svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor"><path d="M7 2C4.243 2 2 4.243 2 7v10c0 2.757 2.243 5 5 5h10c2.757 0 5-2.243 5-5V7c0-2.757-2.243-5-5-5H7zm10 2a3 3 0 0 1 3 3v10a3 3 0 0 1-3 3H7a3 3 0 0 1-3-3V7a3 3 0 0 1 3-3h10zm-5 3.5A4.5 4.5 0 1 0 16.5 12 4.5 4.5 0 0 0 12 7.5zm0 7.3A2.8 2.8 0 1 1 14.8 12 2.8 2.8 0 0 1 12 14.8zM17.4 6.2a1.1 1.1 0 1 0 1.1 1.1 1.1 1.1 0 0 0-1.1-1.1z"/></svg>',
          'TikTok' => '<svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor"><path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z"/></svg>',
          'YouTube' => '<svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>',
          'Facebook' => '<svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>',
          'Twitter/X' => '<svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>',
        ];

        $socialColors = [
          'Instagram' => 'from-pink-500 to-purple-600',
          'TikTok' => 'from-black to-gray-800',
          'YouTube' => 'from-red-600 to-red-700',
          'Facebook' => 'from-blue-600 to-blue-700',
          'Twitter/X' => 'from-blue-400 to-blue-600',
        ];
      @endphp

      @forelse ($packagesByCategory as $category => $categoryPackages)
        <!-- Cabeçalho da Categoria -->
        <div class="mb-12">
          <div class="flex items-center justify-center mb-8">
            <div class="inline-flex items-center space-x-3 bg-white rounded-2xl shadow-lg px-6 py-4">
              <div class="w-10 h-10 rounded-xl bg-gradient-to-r {{ $socialColors[$category] ?? 'from-indigo-500 to-purple-600' }} flex items-center justify-center text-white">
                {!! $socialIcons[$category] ?? '<svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>' !!}
              </div>
              <h2 class="text-3xl font-bold text-gray-900">{{ $category }}</h2>
            </div>
          </div>

          <!-- Grid de Pacotes -->
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach ($categoryPackages as $package)
              @php
                $variant = $variants[$loop->index % count($variants)];
                $bonusByType = $package->bonusItems->keyBy('credit_type');
                $likes = $bonusByType->get('likes');
                $views = $bonusByType->get('views');
                $comments = $bonusByType->get('comments');
                $badgeText = $package->badge_text ?: ($package->is_featured ? 'Mais Vendido' : null);
                $min = $formatAmount($package->display_min);
                $max = $formatAmount($package->display_max);
                $unit = $package->display_unit ?: '';
                $originalPrice = $formatMoney($package->original_price);
                $price = $formatMoney($package->price);
              @endphp

              <div class="group relative bg-white rounded-3xl overflow-visible {{ $package->is_featured ? 'shadow-2xl ring-2 ring-purple-400' : 'shadow-lg' }} hover:shadow-2xl transition-all duration-500 hover:-translate-y-3">
                @if ($badgeText)
                  <div class="absolute -top-2.5 left-1/2 -translate-x-1/2 z-20">
                    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-4 py-1 rounded-full text-[10px] font-bold uppercase tracking-tight shadow-lg flex items-center space-x-1">
                      <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                      </svg>
                      <span>{{ $badgeText }}</span>
                    </div>
                  </div>
                @endif

                <div class="bg-gradient-to-br {{ $package->is_featured ? 'from-purple-100 via-indigo-100 to-purple-200' : $variant['header'] }} p-6 relative overflow-hidden pt-6 rounded-t-3xl">
                  <div class="absolute top-0 right-0 w-40 h-40 bg-white/30 rounded-full -mr-20 -mt-20"></div>
                  <div class="absolute bottom-0 left-0 w-32 h-32 bg-white/25 rounded-full -ml-16 -mb-16"></div>
                  <div class="relative z-10">
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ $package->name }}</h3>
                    @if ($min || $max)
                      <div class="flex items-baseline space-x-1">
                        <span class="text-5xl font-bold {{ $package->is_featured ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-transparent bg-clip-text' : 'text-gray-900' }}">{{ $min ?: $max }}</span>
                        @if ($min && $max)
                          <span class="text-xl text-gray-600">-</span>
                          <span class="text-3xl font-bold {{ $package->is_featured ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-transparent bg-clip-text' : 'text-gray-700' }}">{{ $max }}</span>
                        @endif
                      </div>
                    @endif
                    @if ($unit)
                      <p class="text-sm text-gray-700 font-medium mt-1">{{ $unit }}</p>
                    @endif
                  </div>
                </div>

                <div class="p-6 bg-gradient-to-b {{ $package->is_featured ? 'from-white to-purple-50/30' : $variant['body'] }}">
                  <div class="space-y-3 mb-6">
                    <!-- Likes -->
                    <div class="flex items-start space-x-3 {{ $likes ? '' : 'opacity-40' }}">
                      <div class="flex-shrink-0 w-8 h-8 {{ $likes ? 'bg-pink-100' : 'bg-gray-100' }} rounded-lg flex items-center justify-center">
                        @if ($likes)
                          <svg class="w-4 h-4 text-pink-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                          </svg>
                        @else
                          <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                          </svg>
                        @endif
                      </div>
                      <div class="flex-1">
                        <p class="text-sm font-semibold {{ $likes ? 'text-gray-900' : 'text-gray-400' }}">{{ $likes?->label ?: (($likes ? number_format($likes->amount, 0, ',', '.') . ' Curtidas' : 'Curtidas')) }}</p>
                        <p class="text-xs {{ $likes ? 'text-gray-500' : 'text-gray-400' }}">{{ $likes?->subtitle ?: ($likes ? 'Bônus incluído' : 'Não incluído') }}</p>
                      </div>
                    </div>

                    <!-- Views -->
                    <div class="flex items-start space-x-3 {{ $views ? '' : 'opacity-40' }}">
                      <div class="flex-shrink-0 w-8 h-8 {{ $views ? 'bg-red-100' : 'bg-gray-100' }} rounded-lg flex items-center justify-center relative">
                        @if ($views)
                          <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                          </svg>
                          <span class="absolute -top-1 -right-1 w-4 h-4 flex items-center justify-center">
                            <svg class="w-4 h-4 text-orange-500 drop-shadow-lg" fill="currentColor" viewBox="0 0 16 16"><path d="M9.65,4.05C9.8,4.2,9.95,4.35,10.1,4.5c0.9,0.95,1.6,1.9,2.1,2.8c0.55,1,0.85,1.9,0.85,2.65c0,0.6-0.15,1.2-0.4,1.7 c-0.25,0.45-0.6,0.85-1.05,1.2c-0.45,0.35-1,0.6-1.65,0.8C9.3,13.9,8.65,14,8,14s-1.3-0.1-1.9-0.3s-1.15-0.45-1.65-0.8 C4,12.55,3.65,12.15,3.4,11.7C3.15,11.2,3,10.65,3,10c0-0.6,0.2-1.3,0.65-2.1C3.75,7.7,3.85,7.5,4,7.3c0.8,0.65,1.55,0.8,2.05,0.8 C6.9,8.1,7.7,7.7,8.35,7c0.4-0.5,0.75-1.1,1-1.85C9.45,4.8,9.55,4.45,9.65,4.05 M8,0c0,3.9-0.85,6.1-1.95,6.1C5.45,6.1,4.7,5.45,4,4 c-1.65,1.85-3,4-3,6c0,4,3.7,6,7,6l0,0c3.3,0,7-2,7-6C15,5,8,0,8,0L8,0z"/></svg>
                          </span>
                        @else
                          <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                          </svg>
                        @endif
                      </div>
                      <div class="flex-1">
                        <p class="text-sm font-semibold {{ $views ? 'text-gray-900' : 'text-gray-400' }}">{{ $views?->label ?: ($views ? number_format($views->amount, 0, ',', '.') . ' Visus' : 'Visus Vídeo') }}</p>
                        <p class="text-xs {{ $views ? 'text-gray-500' : 'text-gray-400' }}">{{ $views?->subtitle ?: ($views ? 'Vídeo bônus' : 'Não incluído') }}</p>
                      </div>
                    </div>

                    <!-- Comments -->
                    <div class="flex items-start space-x-3 {{ $comments ? '' : 'opacity-40' }}">
                      <div class="flex-shrink-0 w-8 h-8 {{ $comments ? 'bg-blue-100' : 'bg-gray-100' }} rounded-lg flex items-center justify-center relative">
                        @if ($comments)
                          <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                          </svg>
                          <span class="absolute -top-1 -right-1 w-4 h-4 flex items-center justify-center">
                            <svg class="w-4 h-4 text-orange-500 drop-shadow-lg" fill="currentColor" viewBox="0 0 16 16"><path d="M9.65,4.05C9.8,4.2,9.95,4.35,10.1,4.5c0.9,0.95,1.6,1.9,2.1,2.8c0.55,1,0.85,1.9,0.85,2.65c0,0.6-0.15,1.2-0.4,1.7 c-0.25,0.45-0.6,0.85-1.05,1.2c-0.45,0.35-1,0.6-1.65,0.8C9.3,13.9,8.65,14,8,14s-1.3-0.1-1.9-0.3s-1.15-0.45-1.65-0.8 C4,12.55,3.65,12.15,3.4,11.7C3.15,11.2,3,10.65,3,10c0-0.6,0.2-1.3,0.65-2.1C3.75,7.7,3.85,7.5,4,7.3c0.8,0.65,1.55,0.8,2.05,0.8 C6.9,8.1,7.7,7.7,8.35,7c0.4-0.5,0.75-1.1,1-1.85C9.45,4.8,9.55,4.45,9.65,4.05 M8,0c0,3.9-0.85,6.1-1.95,6.1C5.45,6.1,4.7,5.45,4,4 c-1.65,1.85-3,4-3,6c0,4,3.7,6,7,6l0,0c3.3,0,7-2,7-6C15,5,8,0,8,0L8,0z"/></svg>
                          </span>
                        @else
                          <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                          </svg>
                        @endif
                      </div>
                      <div class="flex-1">
                        <p class="text-sm font-semibold {{ $comments ? 'text-gray-900' : 'text-gray-400' }}">{{ $comments?->label ?: ($comments ? number_format($comments->amount, 0, ',', '.') . ' Comentários' : 'Comentários') }}</p>
                        <p class="text-xs {{ $comments ? 'text-gray-500' : 'text-gray-400' }}">{{ $comments?->subtitle ?: ($comments ? 'Bônus incluído' : 'Não incluído') }}</p>
                      </div>
                    </div>

                    <!-- Multi-posts (fixo) -->
                    <div class="flex items-start space-x-3">
                      <div class="flex-shrink-0 w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                      </div>
                      <div class="flex-1">
                        <p class="text-sm font-semibold text-gray-900">Multi-posts</p>
                        <p class="text-xs text-gray-500">Vários posts</p>
                      </div>
                    </div>
                  </div>

                  <div class="border-t {{ $package->is_featured ? 'border-purple-100' : 'border-gray-100' }} pt-4 mb-6">
                    <div class="flex items-center justify-center space-x-2">
                      @if ($originalPrice)
                        <span class="text-sm text-gray-400 line-through">R$ {{ $originalPrice }}</span>
                      @endif
                      <div class="flex items-baseline">
                        <span class="text-lg text-gray-600">R$</span>
                        <span class="text-4xl font-bold {{ $package->is_featured ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-transparent bg-clip-text' : 'text-gray-900' }}">{{ $price }}</span>
                      </div>
                    </div>
                  </div>

                  @php
                    $ctaHref = $package->cta_href ?: '#comprar';
                    $opensModal = $ctaHref === '#comprar';
                  @endphp

                  <a
                    href="{{ $ctaHref }}"
                    @if ($opensModal)
                      class="js-buy block w-full bg-gradient-to-r {{ $package->is_featured ? 'from-indigo-600 to-purple-600 ring-2 ring-purple-300' : $variant['cta'] }} text-white text-center py-3.5 rounded-xl font-semibold hover:shadow-lg hover:scale-105 transition-all duration-300"
                      data-package-id="{{ $package->id }}"
                      data-package-name="{{ $package->name }}"
                    @else
                      class="block w-full bg-gradient-to-r {{ $package->is_featured ? 'from-indigo-600 to-purple-600 ring-2 ring-purple-300' : $variant['cta'] }} text-white text-center py-3.5 rounded-xl font-semibold hover:shadow-lg hover:scale-105 transition-all duration-300"
                    @endif
                  >
                    {{ $package->cta_label ?: 'Comprar Agora' }}
                  </a>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      @empty
        <div class="text-center py-12">
          <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
            </svg>
          </div>
          <h3 class="text-2xl font-bold text-gray-900 mb-2">Nenhum pacote disponível</h3>
          <p class="text-gray-600">Novos pacotes em breve!</p>
        </div>
      @endforelse
    </div>
  </section>

  <!-- Modal de Compra -->
  <div id="modalCompra" class="fixed inset-0 z-[999] hidden opacity-0 transition-opacity duration-300">
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm"></div>

    <div class="relative min-h-full flex items-center justify-center px-4 py-8">
      <div id="modalContent" class="w-full max-w-lg bg-white rounded-3xl shadow-2xl p-6 sm:p-8 transform scale-95 transition-transform duration-300 border border-white/60">
        <div class="relative">
          <button id="closeModal" type="button" class="absolute -top-2 -right-2 w-10 h-10 rounded-full bg-white/90 hover:bg-white text-gray-500 hover:text-gray-700 shadow flex items-center justify-center">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>

          <div class="flex flex-col items-center text-center">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-indigo-600 to-purple-600 flex items-center justify-center shadow-lg">
              <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 12a5 5 0 1 0-5-5 5 5 0 0 0 5 5zm0 2c-4.33 0-8 2.17-8 5v1h16v-1c0-2.83-3.67-5-8-5z"/>
              </svg>
            </div>

            <h3 class="mt-4 text-3xl font-extrabold text-gray-900">Vamos Começar!</h3>
            <p class="mt-2 text-sm text-gray-600">
              Digite o seu @usuário do Instagram para continuar.
            </p>

            <p class="mt-3 text-xs text-gray-600">
              Pacote: <span id="selectedPackageName" class="font-semibold text-gray-900">—</span>
            </p>
          </div>
        </div>

        <form id="checkoutStartForm" method="POST" action="{{ route('checkout.start') }}" class="space-y-5">
          @csrf

          <input type="hidden" name="package_id" id="selectedPackageId" value="">

          <div>
            <div class="mt-1 flex items-center gap-3 rounded-full border-2 border-indigo-200 bg-white px-4 py-3 shadow-sm focus-within:ring-4 focus-within:ring-indigo-200/60">
              <div class="w-10 h-10 rounded-full bg-gradient-to-br from-indigo-600 to-purple-600 flex items-center justify-center">
                <svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="currentColor">
                  <path d="M7 2C4.243 2 2 4.243 2 7v10c0 2.757 2.243 5 5 5h10c2.757 0 5-2.243 5-5V7c0-2.757-2.243-5-5-5H7zm10 2a3 3 0 0 1 3 3v10a3 3 0 0 1-3 3H7a3 3 0 0 1-3-3V7a3 3 0 0 1 3-3h10zm-5 3.5A4.5 4.5 0 1 0 16.5 12 4.5 4.5 0 0 0 12 7.5zm0 7.3A2.8 2.8 0 1 1 14.8 12 2.8 2.8 0 0 1 12 14.8zM17.4 6.2a1.1 1.1 0 1 0 1.1 1.1 1.1 1.1 0 0 0-1.1-1.1z"/>
                </svg>
              </div>

              <input
                id="instagramUsername"
                name="instagram"
                type="text"
                inputmode="text"
                autocomplete="off"
                placeholder="Digite o seu @usuario"
                class="w-full outline-none text-gray-900 placeholder:text-gray-400"
              />
            </div>

            <div id="igLookupStatus" class="mt-3 hidden rounded-2xl border px-4 py-3 text-sm"></div>

            <div id="igProfilePreview" class="mt-3 hidden rounded-2xl border border-gray-200 bg-gray-50 p-4">
              <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-white border border-gray-200 overflow-hidden flex items-center justify-center">
                  <img id="igProfilePic" src="" alt="Foto de perfil" class="w-full h-full object-cover hidden" referrerpolicy="no-referrer" />
                  <div id="igProfilePicFallback" class="w-full h-full bg-gradient-to-br from-indigo-100 to-purple-100"></div>
                </div>

                <div class="min-w-0">
                  <p class="text-sm font-bold text-gray-900 truncate">
                    <span id="igFullName">—</span>
                    <span id="igVerified" class="ml-1 hidden items-center rounded-full bg-indigo-600 text-white px-2 py-0.5 text-[10px] font-bold">Verificado</span>
                  </p>
                  <p class="text-sm text-gray-700 truncate">@<span id="igUsername">—</span></p>
                  <p class="text-xs text-gray-600 mt-1"><span id="igFollowers">0</span> seguidores • <span id="igFollowing">0</span> seguindo</p>
                </div>
              </div>

              <p id="igBio" class="text-xs text-gray-600 mt-3 line-clamp-2">&nbsp;</p>
            </div>

            <p class="text-xs text-gray-500 mt-3">Aceita com ou sem @ (sem espaços)</p>
          </div>

          <label class="flex items-start gap-3">
            <input id="acceptTerms" type="checkbox" class="mt-1 w-5 h-5 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" />
            <span class="text-sm text-gray-700 leading-snug">
              Li e estou de acordo com os
              <a href="#" class="underline underline-offset-2 decoration-indigo-400 hover:text-indigo-700">termos de compra</a>
              e de
              <a href="#" class="underline underline-offset-2 decoration-indigo-400 hover:text-indigo-700">responsabilidade</a>.
            </span>
          </label>

          <div>
            <p class="text-3xl font-extrabold text-gray-900 text-center">Pagamento</p>
          </div>

          <button
            id="btnPagarAgora"
            type="submit"
            disabled
            class="w-full bg-gradient-to-r from-green-600 to-green-700 text-white py-4 rounded-full font-bold text-lg hover:from-green-700 hover:to-green-800 transition-all shadow-lg hover:shadow-xl disabled:opacity-40 disabled:cursor-not-allowed disabled:hover:from-green-600 disabled:hover:to-green-700"
          >
            Pagar Agora
          </button>
        </form>
      </div>
    </div>
  </div>

  <script>
    // Menu mobile
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');

    if (mobileMenuBtn && mobileMenu) {
      mobileMenuBtn.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
      });
    }

    // Modal de Compra
    const modal = document.getElementById('modalCompra');
    const modalContent = document.getElementById('modalContent');
    const closeModalBtn = document.getElementById('closeModal');
    const instagramInput = document.getElementById('instagramUsername');
    const acceptTermsCheckbox = document.getElementById('acceptTerms');
    const btnPagarAgora = document.getElementById('btnPagarAgora');
    const comprarButtons = document.querySelectorAll('.js-buy');
    const selectedPackageId = document.getElementById('selectedPackageId');
    const selectedPackageName = document.getElementById('selectedPackageName');
    const checkoutStartForm = document.getElementById('checkoutStartForm');

    // Verificar se os elementos do modal existem
    if (modal && modalContent && closeModalBtn && instagramInput && acceptTermsCheckbox && btnPagarAgora) {
      // Abrir modal quando clicar em qualquer botão "Comprar Agora"
      comprarButtons.forEach(button => {
        button.addEventListener('click', (e) => {
          e.preventDefault();
          if (selectedPackageId) {
            selectedPackageId.value = button.dataset.packageId || '';
          }
          if (selectedPackageName) {
            selectedPackageName.textContent = button.dataset.packageName || '—';
          }
          openModal();
          validateForm();
        });
      });

      function openModal() {
        modal.classList.remove('hidden');
        // Força o reflow para a animação funcionar
        modal.offsetHeight;
        modal.classList.remove('opacity-0');
        modalContent.classList.remove('scale-95');
        modalContent.classList.add('scale-100');
        document.body.style.overflow = 'hidden';
      }

      function closeModal() {
        modal.classList.add('opacity-0');
        modalContent.classList.remove('scale-100');
        modalContent.classList.add('scale-95');
        setTimeout(() => {
          modal.classList.add('hidden');
          document.body.style.overflow = '';
          // Limpar campos
          instagramInput.value = '';
          acceptTermsCheckbox.checked = false;
          btnPagarAgora.disabled = true;
          igLookup = { status: 'idle', exists: false, isPrivate: false, profile: null };
          igLookupRequestId++;
          setStatus('ok', '');
          hidePreview();
          if (selectedPackageId) {
            selectedPackageId.value = '';
          }
          if (selectedPackageName) {
            selectedPackageName.textContent = '—';
          }
        }, 300);
      }

      // Fechar modal ao clicar no botão X
      closeModalBtn.addEventListener('click', closeModal);

      // Fechar modal ao clicar fora do conteúdo
      modal.addEventListener('click', (e) => {
        const clickedOutside = e.target === modal || e.target.classList.contains('bg-black/60');
        if (clickedOutside) {
          closeModal();
        }
      });

      // Fechar modal com tecla ESC
      document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
          closeModal();
        }
      });

      // Habilitar/desabilitar botão baseado nos campos
      const igLookupStatus = document.getElementById('igLookupStatus');
      const igProfilePreview = document.getElementById('igProfilePreview');
      const igProfilePic = document.getElementById('igProfilePic');
      const igProfilePicFallback = document.getElementById('igProfilePicFallback');
      const igFullName = document.getElementById('igFullName');
      const igUsername = document.getElementById('igUsername');
      const igVerified = document.getElementById('igVerified');
      const igFollowers = document.getElementById('igFollowers');
      const igFollowing = document.getElementById('igFollowing');
      const igBio = document.getElementById('igBio');

      const igLookupUrl = @json(route('instagram.lookup'));
      const igCsrfToken = @json(csrf_token());

      let igLookup = { status: 'idle', exists: false, isPrivate: false, profile: null };
      let igLookupTimer = null;
      let igLookupRequestId = 0;

      function normalizeUsername(value) {
        return String(value || '').trim().replace(/^@+/, '');
      }

      function setStatus(type, message) {
        if (!igLookupStatus) return;
        if (!message) {
          igLookupStatus.classList.add('hidden');
          igLookupStatus.textContent = '';
          igLookupStatus.className = 'mt-3 hidden rounded-2xl border px-4 py-3 text-sm';
          return;
        }

        igLookupStatus.classList.remove('hidden');
        igLookupStatus.textContent = message;
        igLookupStatus.className = 'mt-3 rounded-2xl border px-4 py-3 text-sm';

        if (type === 'loading') {
          igLookupStatus.classList.add('border-gray-200', 'bg-gray-50', 'text-gray-700');
        } else if (type === 'error') {
          igLookupStatus.classList.add('border-red-200', 'bg-red-50', 'text-red-800');
        } else if (type === 'warning') {
          igLookupStatus.classList.add('border-amber-200', 'bg-amber-50', 'text-amber-900');
        } else {
          igLookupStatus.classList.add('border-indigo-200', 'bg-indigo-50', 'text-indigo-900');
        }
      }

      function hidePreview() {
        if (igProfilePreview) igProfilePreview.classList.add('hidden');
      }

      function showPreview(profile) {
        if (!igProfilePreview) return;
        igProfilePreview.classList.remove('hidden');

        const picDataUrl = (profile?.profile_pic_data_url || '').toString();
        const picUrl = (profile?.profile_pic_url || '').toString();
        const pic = picDataUrl || picUrl;
        const fullName = (profile?.full_name || '').toString();
        const uname = (profile?.username || '').toString();
        const bio = (profile?.biography || '').toString();
        const followers = Number(profile?.follower_count || 0);
        const following = Number(profile?.following_count || 0);
        const verified = Boolean(profile?.is_verified);

        if (igFullName) igFullName.textContent = fullName || ('@' + uname);
        if (igUsername) igUsername.textContent = uname;
        if (igBio) igBio.textContent = bio || '';
        if (igFollowers) igFollowers.textContent = followers.toLocaleString('pt-BR');
        if (igFollowing) igFollowing.textContent = following.toLocaleString('pt-BR');

        if (igVerified) {
          if (verified) {
            igVerified.classList.remove('hidden');
            igVerified.classList.add('inline-flex');
          } else {
            igVerified.classList.add('hidden');
            igVerified.classList.remove('inline-flex');
          }
        }

        if (igProfilePic && igProfilePicFallback) {
          if (pic) {
            igProfilePic.src = pic;
            igProfilePic.classList.remove('hidden');
            igProfilePicFallback.classList.add('hidden');
          } else {
            igProfilePic.src = '';
            igProfilePic.classList.add('hidden');
            igProfilePicFallback.classList.remove('hidden');
          }
        }
      }

      async function fetchInstagramProfile(username) {
        const requestId = ++igLookupRequestId;
        igLookup = { status: 'loading', exists: false, isPrivate: false, profile: null };
        setStatus('loading', 'Buscando seu perfil no Instagram...');
        hidePreview();
        validateForm();

        const res = await fetch(igLookupUrl, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': igCsrfToken,
          },
          body: JSON.stringify({ username }),
        });

        const json = await res.json().catch(() => null);

        if (requestId !== igLookupRequestId) {
          return;
        }

        if (!res.ok || !json) {
          const msg =
            json?.message ||
            json?.errors?.username?.[0] ||
            'Não foi possível validar o Instagram agora. Tente novamente.';

          igLookup = { status: 'error', exists: false, isPrivate: false, profile: null };
          setStatus('error', msg);
          hidePreview();
          validateForm();
          return;
        }

        if (!json.ok) {
          igLookup = { status: 'error', exists: false, isPrivate: false, profile: null };
          setStatus('error', json.message || 'Não foi possível validar o Instagram agora.');
          hidePreview();
          validateForm();
          return;
        }

        if (!json.exists) {
          igLookup = { status: 'not_found', exists: false, isPrivate: false, profile: null };
          setStatus('error', 'Esse perfil não foi encontrado. Verifique o @ e tente novamente.');
          hidePreview();
          validateForm();
          return;
        }

        igLookup = {
          status: 'ready',
          exists: true,
          isPrivate: Boolean(json.is_private),
          profile: json.profile || null,
        };

        showPreview(igLookup.profile);

        if (igLookup.isPrivate) {
          setStatus(
            'warning',
            'Seu perfil está privado. Você pode pagar agora, mas o pedido só será processado quando o perfil estiver público.',
          );
        } else {
          setStatus('ok', 'Perfil encontrado e validado.');
        }

        validateForm();
      }

      function validateForm() {
        const rawUsername = instagramInput.value.trim();
        const username = normalizeUsername(rawUsername);
        const termsAccepted = acceptTermsCheckbox.checked;
        const packageSelected = (selectedPackageId?.value || '').length > 0;

        const isValidUsername =
          username.length >= 3 &&
          !username.includes(' ') &&
          /^[A-Za-z0-9._]+$/.test(username);

        const lookupOk = igLookup.status === 'ready' && igLookup.exists;

        btnPagarAgora.disabled = !(isValidUsername && termsAccepted && packageSelected && lookupOk);
      }

      instagramInput.addEventListener('input', () => {
        validateForm();

        const username = normalizeUsername(instagramInput.value);
        if (igLookupTimer) clearTimeout(igLookupTimer);

        if (username.length < 3) {
          igLookup = { status: 'idle', exists: false, isPrivate: false, profile: null };
          setStatus('ok', '');
          hidePreview();
          validateForm();
          return;
        }

        if (!/^[A-Za-z0-9._]+$/.test(username)) {
          igLookup = { status: 'idle', exists: false, isPrivate: false, profile: null };
          setStatus('error', 'Use apenas letras, números, ponto e underscore.');
          hidePreview();
          validateForm();
          return;
        }

        igLookupTimer = setTimeout(() => {
          fetchInstagramProfile(username);
        }, 450);
      });

      acceptTermsCheckbox.addEventListener('change', validateForm);

      // Bloquear submit se inválido
      if (checkoutStartForm) {
        checkoutStartForm.addEventListener('submit', (e) => {
          validateForm();
          if (btnPagarAgora.disabled) {
            e.preventDefault();
            return;
          }

          // Normaliza antes de enviar para bater com a validação do backend (sem @)
          instagramInput.value = instagramInput.value.trim().replace(/^@+/, '');
        });
      }
    }
  </script>

  <style>
    @keyframes blob {
      0%, 100% { transform: translate(0px, 0px) scale(1); }
      33% { transform: translate(30px, -50px) scale(1.1); }
      66% { transform: translate(-20px, 20px) scale(0.9); }
    }

    .animate-blob {
      animation: blob 7s infinite;
    }

    .animation-delay-2000 {
      animation-delay: 2s;
    }
  </style>
</body>

</html>
