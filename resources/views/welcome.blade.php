<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

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
          <a href="#como-funciona" class="text-gray-700 hover:text-indigo-600 font-medium transition">
            Como Funciona
          </a>
          <a href="#pacotes" class="text-gray-700 hover:text-indigo-600 font-medium transition">
            Pacotes
          </a>
          <a href="#duvidas" class="text-gray-700 hover:text-indigo-600 font-medium transition">
            Dúvidas
          </a>
          <a href="#suporte" class="text-gray-700 hover:text-indigo-600 font-medium transition">
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
          <a href="#comprar" class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-6 py-3 rounded-full font-semibold hover:shadow-lg transform hover:-translate-y-0.5 transition flex items-center space-x-2">
            <span>Comprar Agora</span>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
          </a>
        </div>

        <!-- Botão Menu Mobile -->
        <div class="md:hidden">
          <button id="mobile-menu-button" type="button" class="text-gray-700 hover:text-indigo-600 p-2">
            <svg id="menu-icon" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
            <svg id="close-icon" class="h-6 w-6 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>
      </div>
    </div>

    <!-- Menu Mobile -->
    <div id="mobile-menu" class="hidden md:hidden border-t border-gray-200 bg-white">
      <div class="px-4 py-4 space-y-2">
        <a href="#como-funciona" class="block px-4 py-2 text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 rounded-lg transition">
          Como Funciona
        </a>
        <a href="#pacotes" class="block px-4 py-2 text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 rounded-lg transition">
          Pacotes
        </a>
        <a href="#duvidas" class="block px-4 py-2 text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 rounded-lg transition">
          Dúvidas
        </a>
        <a href="#suporte" class="block px-4 py-2 text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 rounded-lg transition">
          Suporte
        </a>
        <a href="#login" class="block px-4 py-2 text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 rounded-lg transition">
          Entrar
        </a>
        <a href="#comprar" class="block text-center bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-6 py-3 rounded-full font-semibold mt-2">
          Comprar Agora
        </a>
      </div>
    </div>
  </nav>

  <!-- Hero Section -->
  <section class="relative bg-gradient-to-br from-gray-50 to-indigo-50 overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full">
      <div class="grid lg:grid-cols-2 gap-12 h-full">

        <!-- Conteúdo Left -->
        <div class="flex flex-col justify-center space-y-6 lg:space-y-8 py-12 lg:py-20">

          <!-- Título Principal -->
          <div class="space-y-3 lg:space-y-4">
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-gray-900 leading-tight">
              Somos Modernos &
              <span class="block bg-gradient-to-r from-indigo-600 to-purple-600 text-transparent bg-clip-text">
                EFETIVOS
              </span>
              <span class="block italic text-gray-700 text-3xl sm:text-4xl lg:text-5xl">Agência de marketing digital</span>
            </h1>
          </div>

          <!-- Descrição -->
          <div class="border-l-4 border-indigo-600 pl-4 lg:pl-6">
            <p class="text-base lg:text-lg text-gray-600 leading-relaxed">
              Diferente dos outros, garantimos seguidores de qualidade com perfis autênticos brasileiros. Nossa tecnologia exclusiva assegura reposição automática em até 30 dias, além de bônus inclusos de curtidas, visualizações e comentários reais que mantêm seu perfil sempre ativo e natural.
            </p>
          </div>

          <!-- CTAs -->
          <div class="flex flex-col sm:flex-row gap-3 lg:gap-4">
            <a href="#comprar" class="inline-flex items-center justify-center space-x-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-8 py-4 lg:py-4 rounded-full font-bold text-base lg:text-lg hover:shadow-xl hover:scale-105 transition-all duration-300 shadow-lg">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
              </svg>
              <span>Comprar Agora</span>
            </a>
            <a href="#servicos" class="inline-flex items-center justify-center space-x-2 bg-white text-indigo-600 px-8 py-3.5 rounded-full font-semibold border-2 border-indigo-600 hover:bg-indigo-50 hover:scale-105 transition-all duration-300">
              <span>Ver Pacotes</span>
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
              </svg>
            </a>
          </div>
        </div>

        <!-- Imagem Right com Badges Flutuantes -->
        <div class="relative flex items-end justify-center pb-0 lg:py-0">
          <div class="w-full relative">
            <!-- Círculo de Fundo Perfeitamente Redondo -->
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[280px] h-[280px] sm:w-[400px] sm:h-[400px] lg:w-[500px] lg:h-[500px] bg-gradient-to-br from-indigo-100 to-purple-100 rounded-full"></div>

            <!-- Imagem Placeholder -->
            <div class="relative z-10 flex items-end justify-center">
              <img src="{{ asset('/images/home-one-hero-main.webp') }}" alt="Agência Digital" class="w-full max-w-[280px] sm:max-w-[380px] lg:max-w-[450px] object-contain object-bottom">
            </div>

            <!-- Badges Flutuantes - Responsivos -->
            <div class="absolute top-12 sm:top-20 left-0 lg:-left-4 bg-purple-600 text-white px-4 py-2 lg:px-6 lg:py-3 rounded-l-full rounded-tr-full shadow-lg animate-float z-20">
              <div class="flex items-center space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                </svg>
                <span class="font-semibold text-xs lg:text-sm">Impulsione</span>
              </div>
            </div>

            <div class="absolute top-6 sm:top-10 right-2 lg:right-4 bg-indigo-600 text-white px-4 py-2 lg:px-6 lg:py-3 rounded-r-full rounded-tl-full shadow-lg animate-float-delayed z-20">
              <div class="flex items-center space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="font-semibold text-xs lg:text-sm">Venda Mais</span>
              </div>
            </div>

            <div class="hidden sm:flex absolute bottom-24 lg:bottom-32 left-0 lg:-left-4 bg-blue-500 text-white px-4 py-2 lg:px-6 lg:py-3 rounded-l-full rounded-br-full shadow-lg animate-float z-20">
              <div class="flex items-center space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <span class="font-semibold text-xs lg:text-sm">Cresça</span>
              </div>
            </div>

            <div class="absolute bottom-12 sm:bottom-20 right-0 bg-orange-500 text-white px-4 py-2 lg:px-6 lg:py-3 rounded-r-full rounded-bl-full shadow-lg animate-float-delayed z-20">
              <div class="flex items-center space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                  <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
                <span class="font-semibold text-xs lg:text-sm">Alcance</span>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>

    <!-- Decorações de Fundo -->
    <div class="absolute top-0 right-0 w-96 h-96 bg-purple-300 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob"></div>
    <div class="absolute bottom-0 left-0 w-96 h-96 bg-indigo-300 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>
  </section>

  <!-- Seção de Pacotes -->
  <section id="pacotes" class="py-16 lg:py-24 bg-gradient-to-br from-gray-50 to-indigo-50 relative overflow-hidden">
    <!-- Decorações de fundo -->
    <div class="absolute top-20 right-0 w-72 h-72 bg-purple-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob"></div>
    <div class="absolute bottom-20 left-0 w-72 h-72 bg-indigo-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">

      <!-- Título da Seção -->
      <div class="text-center mb-12 lg:mb-16">
        <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-gray-900 mb-4">
          Escolha o <span class="bg-gradient-to-r from-indigo-600 to-purple-600 text-transparent bg-clip-text">melhor pacote</span> para aumentar sua visibilidade <span class="bg-gradient-to-r from-indigo-600 to-purple-600 text-transparent bg-clip-text">agora</span>
        </h2>
      </div>

      <!-- Carousel de Pacotes -->
      <div class="relative">
        <!-- Botões de Navegação -->
        <button id="prevBtn" class="hidden lg:flex absolute left-0 top-1/2 -translate-y-1/2 -translate-x-6 z-30 w-12 h-12 bg-white rounded-full shadow-xl items-center justify-center text-indigo-600 hover:bg-indigo-600 hover:text-white transition-all duration-300 hover:scale-110">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
          </svg>
        </button>

        <button id="nextBtn" class="hidden lg:flex absolute right-0 top-1/2 -translate-y-1/2 translate-x-6 z-30 w-12 h-12 bg-white rounded-full shadow-xl items-center justify-center text-indigo-600 hover:bg-indigo-600 hover:text-white transition-all duration-300 hover:scale-110">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
          </svg>
        </button>

        <!-- Container do Carousel -->
        <div id="packagesCarousel" class="overflow-x-auto scrollbar-hide scroll-smooth snap-x snap-mandatory py-8 px-4 md:px-0">
          <div id="packagesCarouselTrack" class="flex gap-6 pb-4" style="width: max-content;">

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
        @endphp

        @forelse (($packages ?? []) as $package)
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

          <div class="package-card group relative bg-white rounded-3xl overflow-visible {{ $package->is_featured ? 'shadow-2xl ring-2 ring-purple-400' : 'shadow-lg' }} hover:shadow-2xl transition-all duration-500 hover:-translate-y-3 snap-center" data-package-id="{{ $package->id }}" data-order-mobile="{{ $package->sort_order_mobile ?? 999999 }}" data-order-desktop="{{ $package->sort_order_desktop ?? ($package->sort_order_mobile ?? 999999) }}" style="width: 280px; flex-shrink: 0; --package-order-mobile: {{ $package->sort_order_mobile ?? 999999 }}; --package-order-desktop: {{ $package->sort_order_desktop ?? ($package->sort_order_mobile ?? 999999) }};">
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
        @empty
          <div class="package-card bg-white rounded-3xl shadow-lg p-8 max-w-md snap-center" data-package-id="0" data-order-mobile="999999" data-order-desktop="999999" style="width: 280px; flex-shrink: 0; --package-order-mobile: 999999; --package-order-desktop: 999999;">
            <h3 class="text-lg font-bold text-gray-900 mb-2">Pacotes em breve</h3>
            <p class="text-sm text-gray-600">Nenhum pacote ativo encontrado no momento.</p>
          </div>
        @endforelse

          </div>
        </div>

        <!-- Indicador de Swipe (Mobile) -->
        <div id="swipeHint" class="lg:hidden flex items-center justify-center gap-2 mt-6 text-indigo-600 font-semibold text-sm animate-pulse">
          <span>Deslize para ver mais</span>
          <svg class="w-5 h-5 animate-bounce-x" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
          </svg>
        </div>

        <!-- Indicadores de Navegação (Dots) - Gerados automaticamente -->
        <div id="carouselDots" class="flex justify-center gap-2 mt-8">
          <!-- Dots serão gerados dinamicamente pelo JavaScript -->
        </div>
      </div>
    </div>
  </section>

  <!-- Seção de Confiança e Resultados -->
  <section class="py-20 lg:py-28 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

      <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center mb-20">
        <!-- Lado Esquerdo - Imagem e Badges -->
        <div class="relative">
          <div class="relative rounded-3xl">
            <!-- Imagem placeholder - Você pode substituir por uma imagem real -->
            <div class="aspect-[3/3] bg-gradient-to-br from-indigo-100 to-purple-100 rounded-2xl flex items-center justify-center overflow-hidden">
              <img src="{{ asset('/images/home-one-about-thumb-main.webp') }}" alt="Imagem de Confiança" class="w-full h-full object-cover rounded-2xl">
            </div>
          </div>

          <!-- Badge flutuante: Crescimento -->
          <div class="absolute -top-4 right-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-6 py-3 rounded-r-full rounded-tl-full shadow-xl">
            <div class="flex items-center space-x-2">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
              </svg>
              <span class="font-bold text-sm">Crescimento Real</span>
            </div>
          </div>

          <!-- Badge flutuante: Clientes Confiantes -->
          <div class="absolute -bottom-4 left-4 bg-white px-6 py-3 rounded-full shadow-xl border border-gray-100">
            <div class="flex items-center space-x-3">
              <div class="flex -space-x-2">
                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 border-2 border-white"></div>
                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-purple-400 to-purple-600 border-2 border-white"></div>
                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-pink-400 to-pink-600 border-2 border-white"></div>
                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-green-400 to-green-600 border-2 border-white"></div>
              </div>
              <span class="font-bold text-gray-900 text-sm">+50K Clientes</span>
            </div>
          </div>
        </div>

        <!-- Lado Direito - Texto e Benefícios -->
        <div>
          <div class="inline-block bg-indigo-100 text-indigo-700 px-4 py-2 rounded-full text-sm font-semibold mb-6">
            Por que Confiar?
          </div>

          <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-6 leading-tight">
            Transformando Perfis,<br/>
            <span class="text-indigo-600">Elevando Resultados</span>
          </h2>

          <p class="text-gray-600 text-lg mb-8 leading-relaxed">
            Definidos pela excelência no marketing digital, emergimos como referência de inovação e resultados comprovados.
          </p>

          <!-- Lista de Benefícios -->
          <div class="grid sm:grid-cols-2 gap-4 mb-8">
            <div class="bg-white rounded-xl p-4 shadow-sm hover:shadow-md transition-shadow">
              <div class="flex items-center space-x-3">
                <div class="flex-shrink-0 w-6 h-6 bg-indigo-100 rounded-lg flex items-center justify-center">
                  <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                  </svg>
                </div>
                <span class="text-gray-700 font-medium text-sm">Seguidores brasileiros</span>
              </div>
            </div>

            <div class="bg-white rounded-xl p-4 shadow-sm hover:shadow-md transition-shadow">
              <div class="flex items-center space-x-3">
                <div class="flex-shrink-0 w-6 h-6 bg-indigo-100 rounded-lg flex items-center justify-center">
                  <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                  </svg>
                </div>
                <span class="text-gray-700 font-medium text-sm">Garantia de reposição 30 dias</span>
              </div>
            </div>

            <div class="bg-white rounded-xl p-4 shadow-sm hover:shadow-md transition-shadow">
              <div class="flex items-center space-x-3">
                <div class="flex-shrink-0 w-6 h-6 bg-indigo-100 rounded-lg flex items-center justify-center">
                  <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                  </svg>
                </div>
                <span class="text-gray-700 font-medium text-sm">Entrega imediata</span>
              </div>
            </div>

            <div class="bg-white rounded-xl p-4 shadow-sm hover:shadow-md transition-shadow">
              <div class="flex items-center space-x-3">
                <div class="flex-shrink-0 w-6 h-6 bg-indigo-100 rounded-lg flex items-center justify-center">
                  <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                  </svg>
                </div>
                <span class="text-gray-700 font-medium text-sm">Suporte 24/7 disponível</span>
              </div>
            </div>
          </div>

          <a href="#pacotes" class="inline-flex items-center space-x-2 bg-indigo-600 text-white px-8 py-4 rounded-full font-semibold hover:bg-indigo-700 transition-colors shadow-lg hover:shadow-xl">
            <span>Escolher Pacote</span>
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
            </svg>
          </a>
        </div>
      </div>

      <!-- Estatísticas em Cards -->
      <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 relative">
        <!-- Card 1 -->
        <div class="bg-indigo-50 rounded-3xl p-8 text-center relative overflow-hidden">
          <div class="absolute top-0 right-0 w-32 h-32 bg-indigo-100 rounded-full -mr-16 -mt-16 opacity-50"></div>
          <div class="relative">
            <div class="text-5xl lg:text-6xl font-bold text-gray-900 mb-2">50K+</div>
            <div class="h-1 w-16 bg-indigo-600 mx-auto mb-3 rounded-full"></div>
            <div class="text-gray-600 font-medium">Clientes Satisfeitos</div>
          </div>
        </div>

        <!-- Card 2 -->
        <div class="bg-purple-50 rounded-3xl p-8 text-center relative overflow-hidden">
          <div class="absolute top-0 right-0 w-32 h-32 bg-purple-100 rounded-full -mr-16 -mt-16 opacity-50"></div>
          <div class="relative">
            <div class="text-5xl lg:text-6xl font-bold text-gray-900 mb-2">28K+</div>
            <div class="h-1 w-16 bg-purple-600 mx-auto mb-3 rounded-full"></div>
            <div class="text-gray-600 font-medium">Projetos Completos</div>
          </div>
        </div>

        <!-- Card 3 -->
        <div class="bg-pink-50 rounded-3xl p-8 text-center relative overflow-hidden sm:col-span-2 lg:col-span-1">
          <div class="absolute top-0 right-0 w-32 h-32 bg-pink-100 rounded-full -mr-16 -mt-16 opacity-50"></div>
          <div class="relative">
            <div class="text-5xl lg:text-6xl font-bold text-gray-900 mb-2">5+</div>
            <div class="h-1 w-16 bg-pink-600 mx-auto mb-3 rounded-full"></div>
            <div class="text-gray-600 font-medium">Anos de Experiência</div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Seção de Depoimentos Dark -->
  <section class="py-20 lg:py-28 bg-gradient-to-br from-gray-900 via-slate-900 to-gray-900 relative overflow-hidden">
    <!-- Padrão de grid de fundo -->
    <div class="absolute inset-0 bg-[linear-gradient(rgba(99,102,241,0.03)_1px,transparent_1px),linear-gradient(90deg,rgba(99,102,241,0.03)_1px,transparent_1px)] bg-[size:50px_50px]"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
      <!-- Header -->
      <div class="text-center mb-16">
        <div class="inline-block bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-6 py-2.5 rounded-full text-sm font-semibold mb-6 shadow-lg">
          Nossos Depoimentos
        </div>
        <h2 class="text-4xl lg:text-5xl font-bold text-white mb-4">
          O que Clientes Dizem Sobre Nossos Serviços
        </h2>
      </div>

      <!-- Testimonial Carousel Container -->
      <div id="testimonialCarousel" class="relative">
        <!-- Testimonial 1 -->
        <div class="testimonial-slide grid lg:grid-cols-2 gap-8 lg:gap-12 items-center">
          <!-- Lado Esquerdo - Imagem -->
          <div class="relative order-2 lg:order-1 max-w-sm mx-auto">
            <div class="relative rounded-3xl overflow-hidden shadow-2xl">
              <!-- Você pode substituir por imagem real -->
              <div class="aspect-square bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center">
                <img src="{{ asset('/images/testimonial-thumb.webp') }}" alt="Imagem de Depoimento" class="w-full h-full object-cover rounded-2xl">
              </div>
            </div>

            <!-- Badge Trusted Clients -->
            <div class="absolute -bottom-4 left-1/2 -translate-x-1/2 bg-white px-6 py-3 rounded-full shadow-2xl">
              <div class="flex items-center space-x-3">
                <span class="font-bold text-gray-900 text-sm">Clientes Confiantes</span>
                <div class="flex -space-x-2">
                  <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 border-2 border-white"></div>
                  <div class="w-8 h-8 rounded-full bg-gradient-to-br from-purple-400 to-purple-600 border-2 border-white"></div>
                  <div class="w-8 h-8 rounded-full bg-gradient-to-br from-pink-400 to-pink-600 border-2 border-white"></div>
                  <div class="w-8 h-8 rounded-full bg-gradient-to-br from-green-400 to-green-600 border-2 border-white"></div>
                </div>
              </div>
            </div>
          </div>

          <!-- Lado Direito - Card de Depoimento -->
          <div class="bg-gradient-to-br from-indigo-600 to-purple-600 rounded-3xl p-10 lg:p-12 shadow-2xl order-1 lg:order-2 relative overflow-hidden">
            <!-- Padrão decorativo -->
            <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full -mr-32 -mt-32"></div>
            <div class="absolute bottom-0 left-0 w-48 h-48 bg-white/5 rounded-full -ml-24 -mb-24"></div>

            <div class="relative">
              <!-- Ícone de Aspas -->
              <svg class="w-16 h-16 text-white/20 mb-6" fill="currentColor" viewBox="0 0 24 24">
                <path d="M6 17h3l2-4V7H5v6h3zm8 0h3l2-4V7h-6v6h3z"/>
              </svg>

              <!-- Rating -->
              <div class="flex items-center justify-between mb-6">
                <span class="text-white font-semibold text-lg">Serviço de Qualidade</span>
                <div class="flex space-x-1 text-yellow-300">
                  <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                  <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                  <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                  <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                  <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                </div>
              </div>

              <!-- Depoimento -->
              <p class="text-white/95 text-lg lg:text-xl leading-relaxed mb-8">
                Comprei o pacote Turbinado e em 24 horas já recebi todos os seguidores! Meu perfil explodiu de engajamento. Os seguidores são brasileiros reais e ativos. Super recomendo o serviço!
              </p>

              <!-- Cliente Info -->
              <div class="flex items-center space-x-4">
                <div class="w-14 h-14 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center text-white font-bold text-lg border-2 border-white/30">
                  MC
                </div>
                <div>
                  <div class="text-white font-bold text-lg">Maria Clara</div>
                  <div class="text-white/70 text-sm">Empreendedora Digital</div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Testimonial 2 -->
        <div class="testimonial-slide hidden grid lg:grid-cols-2 gap-8 lg:gap-12 items-center">
          <!-- Lado Esquerdo - Imagem -->
          <div class="relative order-2 lg:order-1 max-w-sm mx-auto">
            <div class="relative rounded-3xl overflow-hidden shadow-2xl">
              <div class="aspect-square bg-gradient-to-br from-purple-500 to-pink-600 flex items-center justify-center">
                <img src="{{ asset('/images/testimonial-thumb.webp') }}" alt="Imagem de Depoimento" class="w-full h-full object-cover rounded-2xl">
              </div>
            </div>

            <div class="absolute -bottom-4 left-1/2 -translate-x-1/2 bg-white px-6 py-3 rounded-full shadow-2xl">
              <div class="flex items-center space-x-3">
                <span class="font-bold text-gray-900 text-sm">Clientes Confiantes</span>
                <div class="flex -space-x-2">
                  <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 border-2 border-white"></div>
                  <div class="w-8 h-8 rounded-full bg-gradient-to-br from-purple-400 to-purple-600 border-2 border-white"></div>
                  <div class="w-8 h-8 rounded-full bg-gradient-to-br from-pink-400 to-pink-600 border-2 border-white"></div>
                  <div class="w-8 h-8 rounded-full bg-gradient-to-br from-green-400 to-green-600 border-2 border-white"></div>
                </div>
              </div>
            </div>
          </div>

          <div class="bg-gradient-to-br from-purple-600 to-pink-600 rounded-3xl p-10 lg:p-12 shadow-2xl order-1 lg:order-2 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full -mr-32 -mt-32"></div>
            <div class="absolute bottom-0 left-0 w-48 h-48 bg-white/5 rounded-full -ml-24 -mb-24"></div>

            <div class="relative">
              <svg class="w-16 h-16 text-white/20 mb-6" fill="currentColor" viewBox="0 0 24 24">
                <path d="M6 17h3l2-4V7H5v6h3zm8 0h3l2-4V7h-6v6h3z"/>
              </svg>

              <div class="flex items-center justify-between mb-6">
                <span class="text-white font-semibold text-lg">Serviço de Qualidade</span>
                <div class="flex space-x-1 text-yellow-300">
                  <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                  <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                  <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                  <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                  <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                </div>
              </div>

              <p class="text-white/95 text-lg lg:text-xl leading-relaxed mb-8">
                Estava desconfiado no início, mas o serviço é REAL! Seguidores brasileiros de qualidade. O suporte respondeu super rápido todas minhas dúvidas. Já indiquei para vários amigos!
              </p>

              <div class="flex items-center space-x-4">
                <div class="w-14 h-14 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center text-white font-bold text-lg border-2 border-white/30">
                  RS
                </div>
                <div>
                  <div class="text-white font-bold text-lg">Rafael Santos</div>
                  <div class="text-white/70 text-sm">Influencer & Coach</div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Testimonial 3 -->
        <div class="testimonial-slide hidden grid lg:grid-cols-2 gap-8 lg:gap-12 items-center">
          <div class="relative order-2 lg:order-1 max-w-sm mx-auto">
            <div class="relative rounded-3xl overflow-hidden shadow-2xl">
              <div class="aspect-square bg-gradient-to-br from-green-500 to-emerald-600 flex items-center justify-center">
                <img src="{{ asset('/images/testimonial-thumb.webp') }}" alt="Imagem de Depoimento" class="w-full h-full object-cover rounded-2xl">
              </div>
            </div>

            <div class="absolute -bottom-4 left-1/2 -translate-x-1/2 bg-white px-6 py-3 rounded-full shadow-2xl">
              <div class="flex items-center space-x-3">
                <span class="font-bold text-gray-900 text-sm">Clientes Confiantes</span>
                <div class="flex -space-x-2">
                  <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 border-2 border-white"></div>
                  <div class="w-8 h-8 rounded-full bg-gradient-to-br from-purple-400 to-purple-600 border-2 border-white"></div>
                  <div class="w-8 h-8 rounded-full bg-gradient-to-br from-pink-400 to-pink-600 border-2 border-white"></div>
                  <div class="w-8 h-8 rounded-full bg-gradient-to-br from-green-400 to-green-600 border-2 border-white"></div>
                </div>
              </div>
            </div>
          </div>

          <div class="bg-gradient-to-br from-green-600 to-emerald-600 rounded-3xl p-10 lg:p-12 shadow-2xl order-1 lg:order-2 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full -mr-32 -mt-32"></div>
            <div class="absolute bottom-0 left-0 w-48 h-48 bg-white/5 rounded-full -ml-24 -mb-24"></div>

            <div class="relative">
              <svg class="w-16 h-16 text-white/20 mb-6" fill="currentColor" viewBox="0 0 24 24">
                <path d="M6 17h3l2-4V7H5v6h3zm8 0h3l2-4V7h-6v6h3z"/>
              </svg>

              <div class="flex items-center justify-between mb-6">
                <span class="text-white font-semibold text-lg">Serviço de Qualidade</span>
                <div class="flex space-x-1 text-yellow-300">
                  <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                  <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                  <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                  <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                  <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                </div>
              </div>

              <p class="text-white/95 text-lg lg:text-xl leading-relaxed mb-8">
                3ª vez que compro! A garantia de reposição funciona mesmo. Minha loja aumentou 300% nas vendas depois que cresci no Instagram. Melhor investimento que fiz!
              </p>

              <div class="flex items-center space-x-4">
                <div class="w-14 h-14 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center text-white font-bold text-lg border-2 border-white/30">
                  JA
                </div>
                <div>
                  <div class="text-white font-bold text-lg">Júlia Almeida</div>
                  <div class="text-white/70 text-sm">Proprietária E-commerce</div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Controles de Navegação -->
        <div class="flex items-center justify-center gap-6 mt-12">
          <!-- Botão Anterior -->
          <button id="prevTestimonial" class="w-12 h-12 rounded-full bg-indigo-600 hover:bg-indigo-700 flex items-center justify-center text-white transition-all shadow-lg hover:scale-110">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
          </button>

          <!-- Indicadores -->
          <div class="flex space-x-2">
            <button class="testimonial-dot w-3 h-3 rounded-full bg-indigo-600 transition-all" data-index="0"></button>
            <button class="testimonial-dot w-3 h-3 rounded-full bg-white/30 transition-all" data-index="1"></button>
            <button class="testimonial-dot w-3 h-3 rounded-full bg-white/30 transition-all" data-index="2"></button>
          </div>

          <!-- Botão Próximo -->
          <button id="nextTestimonial" class="w-12 h-12 rounded-full bg-indigo-600 hover:bg-indigo-700 flex items-center justify-center text-white transition-all shadow-lg hover:scale-110">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
            </svg>
          </button>
        </div>
      </div>
    </div>
  </section>

  <!-- Seção de Garantia -->
  <section class="py-20 lg:py-28 bg-gradient-to-br from-green-50 to-emerald-50 relative overflow-hidden">
    <!-- Padrão decorativo -->
    <div class="absolute top-0 right-0 w-96 h-96 bg-green-200/20 rounded-full -mr-48 -mt-48"></div>
    <div class="absolute bottom-0 left-0 w-96 h-96 bg-emerald-200/20 rounded-full -ml-48 -mb-48"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
      <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center">
        <!-- Lado Esquerdo - Imagem -->
        <div class="flex justify-center lg:justify-start order-2 lg:order-1">
          <div class="relative">
            <img src="{{ asset('/images/garantia.png') }}" alt="Garantia de 7 Dias" class="w-64 h-64 lg:w-80 lg:h-80 object-contain drop-shadow-2xl">
            <!-- Badge flutuante -->
            <div class="absolute -top-4 -right-4 bg-green-600 text-white px-5 py-2.5 rounded-full shadow-xl animate-pulse">
              <span class="font-bold text-sm">100% Seguro</span>
            </div>
          </div>
        </div>

        <!-- Lado Direito - Texto -->
        <div class="order-1 lg:order-2">
          <div class="inline-block bg-green-600 text-white px-5 py-2.5 rounded-full text-sm font-semibold mb-6">
            Nossa Garantia
          </div>

          <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-6 leading-tight">
            Garantia de <span class="text-green-600">7 Dias</span><br/>
            <span class="text-2xl lg:text-3xl text-gray-700 font-normal">ou seu dinheiro de volta</span>
          </h2>

          <p class="text-gray-700 text-lg lg:text-xl mb-8 leading-relaxed">
            Compre com total tranquilidade! Se você não ficar satisfeito com os resultados em até 7 dias, devolvemos 100% do seu investimento. Sem perguntas, sem burocracia.
          </p>

          <!-- Lista de Benefícios -->
          <div class="space-y-4 mb-8">
            <div class="flex items-start space-x-4">
              <div class="flex-shrink-0 w-8 h-8 bg-green-600 rounded-full flex items-center justify-center mt-1">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
              </div>
              <div>
                <h3 class="text-gray-900 font-bold text-lg mb-1">Reembolso total em até 7 dias</h3>
                <p class="text-gray-600 text-sm">Devolução de 100% do valor investido sem complicações</p>
              </div>
            </div>

            <div class="flex items-start space-x-4">
              <div class="flex-shrink-0 w-8 h-8 bg-green-600 rounded-full flex items-center justify-center mt-1">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
              </div>
              <div>
                <h3 class="text-gray-900 font-bold text-lg mb-1">Sem perguntas ou burocracia</h3>
                <p class="text-gray-600 text-sm">Processo simples e rápido, apenas um clique</p>
              </div>
            </div>

            <div class="flex items-start space-x-4">
              <div class="flex-shrink-0 w-8 h-8 bg-green-600 rounded-full flex items-center justify-center mt-1">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
              </div>
              <div>
                <h3 class="text-gray-900 font-bold text-lg mb-1">Suporte dedicado 24/7</h3>
                <p class="text-gray-600 text-sm">Equipe disponível para tirar suas dúvidas a qualquer momento</p>
              </div>
            </div>
          </div>

          <a href="#pacotes" class="inline-flex items-center space-x-2 bg-green-600 text-white px-8 py-4 rounded-full font-bold text-lg hover:bg-green-700 transition-all shadow-xl hover:shadow-2xl hover:scale-105">
            <span>Comprar Agora com Garantia</span>
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
            </svg>
          </a>
        </div>
      </div>
    </div>
  </section>

  <!-- Seção de Blog -->
  <section class="hidden py-20 lg:py-28 bg-gradient-to-br from-gray-50 to-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <!-- Cabeçalho -->
      <div class="text-center mb-16">
        <div class="inline-block bg-indigo-50 text-indigo-600 px-4 py-2 rounded-full text-sm font-semibold mb-4">
          Nosso Blog
        </div>
        <h2 class="text-3xl lg:text-5xl font-bold text-gray-900 mb-4">
          Últimas <span class="text-indigo-600">Publicações</span>
        </h2>
        <p class="text-lg text-gray-600 max-w-2xl mx-auto">
          Dicas, estratégias e novidades para você crescer no Instagram
        </p>
      </div>

      <!-- Grid de Cards -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 lg:gap-10">

        <!-- Card 1 -->
        <article class="bg-white rounded-2xl overflow-hidden border border-gray-100 hover:shadow-xl transition-all duration-300 group">
          <div class="relative overflow-hidden aspect-[16/10]">
            <img src="{{ asset('/images/blog-1.webp') }}" alt="Como crescer no Instagram" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
            <div class="absolute top-4 left-4">
              <span class="bg-indigo-600 text-white px-3 py-1 rounded-full text-xs font-semibold">
                Estratégias
              </span>
            </div>
          </div>
          <div class="p-6 lg:p-8">
            <div class="flex items-center space-x-4 text-sm text-gray-500 mb-4">
              <time datetime="2026-01-15">15 Jan, 2026</time>
              <span>•</span>
              <span>5 min de leitura</span>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-indigo-600 transition-colors">
              Como Crescer no Instagram em 2026: Guia Completo
            </h3>
            <p class="text-gray-600 leading-relaxed mb-6">
              Descubra as estratégias mais eficazes para aumentar seu alcance e engajamento no Instagram este ano.
            </p>
            <a href="#" class="inline-flex items-center text-indigo-600 font-semibold hover:text-indigo-700 transition-colors">
              Ler mais
              <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
              </svg>
            </a>
          </div>
        </article>

        <!-- Card 2 -->
        <article class="bg-white rounded-2xl overflow-hidden border border-gray-100 hover:shadow-xl transition-all duration-300 group">
          <div class="relative overflow-hidden aspect-[16/10]">
            <img src="{{ asset('/images/blog-2.webp') }}" alt="Algoritmo do Instagram" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
            <div class="absolute top-4 left-4">
              <span class="bg-purple-600 text-white px-3 py-1 rounded-full text-xs font-semibold">
                Dicas
              </span>
            </div>
          </div>
          <div class="p-6 lg:p-8">
            <div class="flex items-center space-x-4 text-sm text-gray-500 mb-4">
              <time datetime="2026-01-12">12 Jan, 2026</time>
              <span>•</span>
              <span>7 min de leitura</span>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-indigo-600 transition-colors">
              Entendendo o Algoritmo do Instagram: O que Mudou?
            </h3>
            <p class="text-gray-600 leading-relaxed mb-6">
              Aprenda como funciona o novo algoritmo e como otimizar seu conteúdo para alcançar mais pessoas.
            </p>
            <a href="#" class="inline-flex items-center text-indigo-600 font-semibold hover:text-indigo-700 transition-colors">
              Ler mais
              <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
              </svg>
            </a>
          </div>
        </article>

        <!-- Card 3 -->
        <article class="bg-white rounded-2xl overflow-hidden border border-gray-100 hover:shadow-xl transition-all duration-300 group">
          <div class="relative overflow-hidden aspect-[16/10]">
            <img src="{{ asset('/images/blog-3.webp') }}" alt="Engajamento no Instagram" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
            <div class="absolute top-4 left-4">
              <span class="bg-pink-600 text-white px-3 py-1 rounded-full text-xs font-semibold">
                Engajamento
              </span>
            </div>
          </div>
          <div class="p-6 lg:p-8">
            <div class="flex items-center space-x-4 text-sm text-gray-500 mb-4">
              <time datetime="2026-01-08">08 Jan, 2026</time>
              <span>•</span>
              <span>6 min de leitura</span>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-indigo-600 transition-colors">
              10 Formas de Aumentar o Engajamento Organicamente
            </h3>
            <p class="text-gray-600 leading-relaxed mb-6">
              Técnicas comprovadas para criar conexões reais com sua audiência e impulsionar suas métricas.
            </p>
            <a href="#" class="inline-flex items-center text-indigo-600 font-semibold hover:text-indigo-700 transition-colors">
              Ler mais
              <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
              </svg>
            </a>
          </div>
        </article>

      </div>

      <!-- Botão Ver Todos os Posts -->
      <div class="text-center mt-12">
        <a href="#" class="inline-flex items-center justify-center px-8 py-4 bg-white border-2 border-indigo-600 text-indigo-600 rounded-full font-bold hover:bg-indigo-600 hover:text-white transition-all duration-300">
          Ver Todos os Posts
          <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
          </svg>
        </a>
      </div>
    </div>
  </section>

  <!-- Seção de FAQ Minimalista -->
  <section class="py-20 lg:py-28 bg-gray-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-16">
        <div class="inline-block bg-indigo-100 text-indigo-700 px-4 py-2 rounded-full text-sm font-semibold mb-6">
          Dúvidas Frequentes
        </div>
        <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-4">
          Perguntas que Recebemos
        </h2>
        <p class="text-gray-600 text-lg">
          Tire suas dúvidas e compre com total confiança
        </p>
      </div>

      <div class="space-y-6">
        <!-- FAQ 1 -->
        <div class="bg-white border border-gray-100 rounded-2xl p-8 hover:shadow-lg transition-shadow">
          <h3 class="font-bold text-gray-900 text-lg mb-3">É seguro para minha conta?</h3>
          <p class="text-gray-600 leading-relaxed">
            Sim! Nosso método é 100% seguro e seguimos todas as diretrizes do Instagram. Usamos apenas perfis reais brasileiros com atividade natural.
          </p>
        </div>

        <!-- FAQ 2 -->
        <div class="bg-white border border-gray-100 rounded-2xl p-8 hover:shadow-lg transition-shadow">
          <h3 class="font-bold text-gray-900 text-lg mb-3">Quanto tempo demora para entregar?</h3>
          <p class="text-gray-600 leading-relaxed">
            Iniciamos a entrega em até 1 hora após confirmação do pagamento. A entrega completa varia de 24h a 7 dias dependendo do pacote escolhido.
          </p>
        </div>

        <!-- FAQ 3 -->
        <div class="bg-white border border-gray-100 rounded-2xl p-8 hover:shadow-lg transition-shadow">
          <h3 class="font-bold text-gray-900 text-lg mb-3">E se os seguidores caírem?</h3>
          <p class="text-gray-600 leading-relaxed">
            Oferecemos garantia de reposição automática de 30 dias. Qualquer queda natural será identificada e reposta automaticamente sem custos adicionais.
          </p>
        </div>

        <!-- FAQ 4 -->
        <div class="bg-white border border-gray-100 rounded-2xl p-8 hover:shadow-lg transition-shadow">
          <h3 class="font-bold text-gray-900 text-lg mb-3">Os seguidores são brasileiros reais?</h3>
          <p class="text-gray-600 leading-relaxed">
            Sim! Trabalhamos exclusivamente com perfis autênticos brasileiros ativos. Você pode verificar a origem e autenticidade após a entrega.
          </p>
        </div>
      </div>
    </div>
  </section>

  <!-- CTA Final com Urgência -->
  <section class="py-16 lg:py-20 bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-600 relative overflow-hidden">
    <!-- Decorações de fundo -->
    <div class="absolute top-0 right-0 w-96 h-96 bg-white/10 rounded-full blur-3xl"></div>
    <div class="absolute bottom-0 left-0 w-96 h-96 bg-white/10 rounded-full blur-3xl"></div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
      <h2 class="text-3xl lg:text-5xl font-bold text-white mb-6">
        Pronto para <span class="underline decoration-wavy decoration-yellow-300">Turbinar</span> seu Instagram?
      </h2>
      <p class="text-lg lg:text-xl text-white/90 mb-8 max-w-2xl mx-auto">
        Junte-se a mais de 50.000 clientes satisfeitos que já transformaram seus perfis com a TurboDigital
      </p>

      <!-- Badge de urgência -->
      <div class="inline-flex items-center space-x-2 bg-yellow-400 text-gray-900 px-6 py-3 rounded-full font-bold mb-8 animate-pulse">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <span>Oferta por tempo limitado!</span>
      </div>

      <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
        <a href="Clean -->
  <section class="py-20 lg:py-32 bg-gradient-to-br from-indigo-50 via-purple-50 to-pink-50">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
      <div class="bg-white rounded-3xl p-12 lg:p-16 shadow-xl border border-gray-100">
        <div class="inline-block bg-gradient-to-r from-indigo-100 to-purple-100 text-indigo-700 px-5 py-2 rounded-full text-sm font-semibold mb-6">
          Comece Agora
        </div>

        <h2 class="text-4xl lg:text-6xl font-bold text-gray-900 mb-6 leading-tight">
          Pronto para Turbinar<br/>
          <span class="text-indigo-600">seu Instagram?</span>
        </h2>

        <p class="text-xl text-gray-600 mb-10 max-w-2xl mx-auto leading-relaxed">
          Junte-se a mais de 50.000 clientes que já transformaram seus perfis com resultados reais e comprovados
        </p>

        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-8">
          <a href="#pacotes" class="inline-flex items-center justify-center space-x-2 bg-indigo-600 text-white px-10 py-5 rounded-full font-bold text-lg hover:bg-indigo-700 transition-all shadow-lg hover:shadow-xl hover:scale-105">
            <span>Ver Pacotes</span>
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
            </svg>
          </a>

          <a href="#suporte" class="inline-flex items-center justify-center space-x-2 bg-white text-gray-700 px-10 py-5 rounded-full font-bold text-lg border-2 border-gray-200 hover:border-indigo-600 hover:text-indigo-600 transition-all">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
            </svg>
            <span>Falar com Suporte</span>
          </a>
        </div>

        <!-- Badges de Confiança -->
        <div class="flex flex-wrap justify-center gap-6 pt-8 border-t border-gray-100">
          <div class="flex items-center space-x-2 text-gray-600">
            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
            </svg>
            <span class="font-medium">Pagamento Seguro</span>
          </div>

          <div class="flex items-center space-x-2 text-gray-600">
            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
            </svg>
            <span class="font-medium">Garantia 30 dias</span>
          </div>

          <div class="flex items-center space-x-2 text-gray-600">
            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
            </svg>
            <span class="font-medium">Suporte 24/7</span>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Rodapé -->
  <footer class="bg-gradient-to-br from-gray-900 via-slate-900 to-gray-900 text-white pt-20 pb-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <!-- Grid Principal -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 lg:gap-16 mb-12">

        <!-- Coluna 1: Logo e Descrição -->
        <div class="lg:col-span-1">
          <div class="flex items-center space-x-3 mb-6">
            <img src="{{ asset('/images/logo-white.svg') }}" alt="TurboDigital Logo" class="h-14 w-auto">
          </div>
          <p class="text-gray-400 leading-relaxed mb-6">
            A plataforma mais confiável para impulsionar seu crescimento no Instagram com seguidores reais e brasileiros.
          </p>
          <!-- Redes Sociais -->
          <div class="flex space-x-4">
            <a href="#" class="bg-white/10 hover:bg-indigo-600 p-3 rounded-lg transition-all duration-300 hover:scale-110">
              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
              </svg>
            </a>
            <a href="#" class="bg-white/10 hover:bg-indigo-600 p-3 rounded-lg transition-all duration-300 hover:scale-110">
              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
              </svg>
            </a>
            <a href="#" class="bg-white/10 hover:bg-indigo-600 p-3 rounded-lg transition-all duration-300 hover:scale-110">
              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                <path d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z"/>
              </svg>
            </a>
          </div>
        </div>

        <!-- Coluna 2: Links Rápidos -->
        <div>
          <h3 class="text-lg font-bold mb-6">Links Rápidos</h3>
          <ul class="space-y-3">
            <li>
              <a href="#inicio" class="text-gray-400 hover:text-white transition-colors flex items-center group">
                <svg class="w-4 h-4 mr-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
                Início
              </a>
            </li>
            <li>
              <a href="#pacotes" class="text-gray-400 hover:text-white transition-colors flex items-center group">
                <svg class="w-4 h-4 mr-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
                Pacotes
              </a>
            </li>
            <li>
              <a href="#blog" class="text-gray-400 hover:text-white transition-colors flex items-center group">
                <svg class="w-4 h-4 mr-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
                Blog
              </a>
            </li>
            <li>
              <a href="#faq" class="text-gray-400 hover:text-white transition-colors flex items-center group">
                <svg class="w-4 h-4 mr-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
                FAQ
              </a>
            </li>
            <li>
              <a href="#depoimentos" class="text-gray-400 hover:text-white transition-colors flex items-center group">
                <svg class="w-4 h-4 mr-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
                Depoimentos
              </a>
            </li>
          </ul>
        </div>

        <!-- Coluna 3: Suporte -->
        <div>
          <h3 class="text-lg font-bold mb-6">Suporte</h3>
          <ul class="space-y-3">
            <li>
              <a href="#" class="text-gray-400 hover:text-white transition-colors flex items-center group">
                <svg class="w-4 h-4 mr-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
                Central de Ajuda
              </a>
            </li>
            <li>
              <a href="#" class="text-gray-400 hover:text-white transition-colors flex items-center group">
                <svg class="w-4 h-4 mr-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
                Termos de Uso
              </a>
            </li>
            <li>
              <a href="#" class="text-gray-400 hover:text-white transition-colors flex items-center group">
                <svg class="w-4 h-4 mr-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
                Política de Privacidade
              </a>
            </li>
            <li>
              <a href="#" class="text-gray-400 hover:text-white transition-colors flex items-center group">
                <svg class="w-4 h-4 mr-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
                Política de Reembolso
              </a>
            </li>
            <li>
              <a href="#" class="text-gray-400 hover:text-white transition-colors flex items-center group">
                <svg class="w-4 h-4 mr-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
                Fale Conosco
              </a>
            </li>
          </ul>
        </div>

        <!-- Coluna 4: Contato -->
        <div>
          <h3 class="text-lg font-bold mb-6">Contato</h3>
          <ul class="space-y-4">
            <li class="flex items-start space-x-3 text-gray-400">
              <svg class="w-5 h-5 text-indigo-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
              </svg>
              <span>contato@turbodigital.com.br</span>
            </li>
            <li class="flex items-start space-x-3 text-gray-400">
              <svg class="w-5 h-5 text-indigo-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
              </svg>
              <span>+55 (11) 9 9999-9999</span>
            </li>
            <li class="flex items-start space-x-3 text-gray-400">
              <svg class="w-5 h-5 text-indigo-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
              </svg>
              <div>
                <p class="font-semibold text-white">Atendimento 24/7</p>
                <p class="text-sm">Todos os dias da semana</p>
              </div>
            </li>
          </ul>
        </div>
      </div>

      <!-- Divisor -->
      <div class="border-t border-gray-800 my-8"></div>

      <!-- Rodapé Inferior -->
      <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
        <p class="text-gray-400 text-sm text-center md:text-left">
          © 2026 TurboDigital. Todos os direitos reservados.
        </p>

        <!-- Métodos de Pagamento -->
        <div class="flex items-center space-x-4">
          <span class="text-gray-400 text-sm">Pagamento seguro:</span>
          <div class="flex items-center space-x-2">
            <div class="bg-white rounded px-2 py-1">
              <span class="text-xs font-bold text-gray-700">VISA</span>
            </div>
            <div class="bg-white rounded px-2 py-1">
              <span class="text-xs font-bold text-gray-700">MASTER</span>
            </div>
            <div class="bg-white rounded px-2 py-1">
              <span class="text-xs font-bold text-blue-600">PIX</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </footer>

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
            class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-4 rounded-full font-extrabold text-lg disabled:opacity-50 disabled:cursor-not-allowed hover:shadow-xl transition"
          >
            Pagar Agora!
          </button>

          <div class="rounded-2xl bg-gray-50 border border-gray-200 p-4 max-h-44 overflow-y-auto">
            <p class="text-sm font-semibold text-gray-700">Termo de Responsabilidade e Uso Ético do Serviço</p>
            <p class="text-xs text-gray-600 mt-3">
              Prezado Usuário, seja muito bem-vindo(a)! Antes de prosseguir com a contratação, é importante que você leia e concorde com os termos.
            </p>
            <p class="text-xs text-gray-600 mt-3">
              Ao continuar, você declara que está ciente das condições, prazos e política de reembolso, bem como do uso ético do serviço.
            </p>
          </div>
        </form>
      </div>
    </div>
  </div>


  <!-- Script para toggle do menu mobile e animações -->
  <script>
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    const menuIcon = document.getElementById('menu-icon');
    const closeIcon = document.getElementById('close-icon');

    mobileMenuButton.addEventListener('click', () => {
      mobileMenu.classList.toggle('hidden');
      menuIcon.classList.toggle('hidden');
      closeIcon.classList.toggle('hidden');
    });

    // Fechar menu ao clicar em um link
    const mobileLinks = mobileMenu.querySelectorAll('a');
    mobileLinks.forEach(link => {
      link.addEventListener('click', () => {
        mobileMenu.classList.add('hidden');
        menuIcon.classList.remove('hidden');
        closeIcon.classList.add('hidden');
      });
    });

    // Carousel de Pacotes - Com geração dinâmica de dots
    const carousel = document.getElementById('packagesCarousel');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const dotsContainer = document.getElementById('carouselDots');
    const carouselTrack = document.getElementById('packagesCarouselTrack');

    let cards = [];
    let totalCards = 0;
    const cardWidth = 280 + 24; // card width + gap
    let dots = [];
    let currentIndex = 0;

    function getOrderValue(card) {
      const isDesktop = window.matchMedia('(min-width: 1024px)').matches;
      const raw = isDesktop ? card.dataset.orderDesktop : card.dataset.orderMobile;
      const value = Number.parseInt(raw ?? '', 10);
      return Number.isFinite(value) ? value : 999999;
    }

    function getPackageId(card) {
      const value = Number.parseInt(card.dataset.packageId ?? '', 10);
      return Number.isFinite(value) ? value : 0;
    }

    function sortCardsByViewport() {
      if (!carouselTrack) return;
      const items = Array.from(carouselTrack.querySelectorAll('.package-card'));
      items.sort((a, b) => {
        const ao = getOrderValue(a);
        const bo = getOrderValue(b);
        if (ao !== bo) return ao - bo;
        return getPackageId(a) - getPackageId(b);
      });
      items.forEach((el) => carouselTrack.appendChild(el));
    }

    function buildDots() {
      dotsContainer.innerHTML = '';
      for (let i = 0; i < totalCards; i++) {
        const dot = document.createElement('button');
        dot.className = `carousel-dot h-2 rounded-full transition-all duration-300 ${
          i === 0 ? 'bg-indigo-600 w-8' : 'bg-gray-300 w-2 hover:bg-indigo-400'
        }`;
        dot.setAttribute('data-index', i);
        dotsContainer.appendChild(dot);
      }
      dots = Array.from(dotsContainer.querySelectorAll('.carousel-dot'));

      dots.forEach((dot, index) => {
        dot.addEventListener('click', () => {
          updateCarousel(index);
        });
      });
    }

    // Esconder hint de swipe após primeira interação
    const swipeHint = document.getElementById('swipeHint');
    let hintHidden = false;

    function hideSwipeHint() {
      if (!hintHidden && swipeHint) {
        swipeHint.style.transition = 'opacity 0.3s';
        swipeHint.style.opacity = '0';
        setTimeout(() => swipeHint.style.display = 'none', 300);
        hintHidden = true;
      }
    }

    carousel.addEventListener('scroll', hideSwipeHint);
    carousel.addEventListener('touchstart', hideSwipeHint);

    function updateCarousel(index) {
      currentIndex = index;
      carousel.scrollTo({
        left: cardWidth * index,
        behavior: 'smooth'
      });

      updateDots(index);
    }

    function updateDots(index) {
      // Update dots
      dots.forEach((dot, i) => {
        if (i === index) {
          dot.classList.remove('bg-gray-300', 'w-2');
          dot.classList.add('bg-indigo-600', 'w-8');
        } else {
          dot.classList.remove('bg-indigo-600', 'w-8');
          dot.classList.add('bg-gray-300', 'w-2');
        }
      });
    }

    // Detectar scroll manual e atualizar dots
    let scrollTimeout;
    carousel.addEventListener('scroll', () => {
      clearTimeout(scrollTimeout);
      scrollTimeout = setTimeout(() => {
        const scrollLeft = carousel.scrollLeft;
        const newIndex = Math.round(scrollLeft / cardWidth);
        if (newIndex !== currentIndex && newIndex >= 0 && newIndex < totalCards) {
          currentIndex = newIndex;
          updateDots(currentIndex);
        }
      }, 100);
    });

    prevBtn.addEventListener('click', () => {
      if (currentIndex > 0) {
        updateCarousel(currentIndex - 1);
      }
    });

    nextBtn.addEventListener('click', () => {
      if (currentIndex < totalCards - 1) {
        updateCarousel(currentIndex + 1);
      }
    });

    function initPackagesCarousel() {
      if (!carousel || !prevBtn || !nextBtn || !dotsContainer || !carouselTrack) return;

      sortCardsByViewport();
      cards = Array.from(carouselTrack.querySelectorAll('.snap-center'));
      totalCards = cards.length;

      currentIndex = 0;
      buildDots();
      updateDots(0);

      carousel.scrollTo({ left: 0, behavior: 'auto' });
    }

    initPackagesCarousel();

    // Se trocar de breakpoint (mobile <-> desktop), reordena e reseta dots
    const media = window.matchMedia('(min-width: 1024px)');
    media.addEventListener('change', () => {
      initPackagesCarousel();
    });

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

    // Carrossel de Depoimentos
    const testimonialSlides = document.querySelectorAll('.testimonial-slide');
    const testimonialDots = document.querySelectorAll('.testimonial-dot');
    const prevTestimonialBtn = document.getElementById('prevTestimonial');
    const nextTestimonialBtn = document.getElementById('nextTestimonial');

    if (testimonialSlides.length > 0 && prevTestimonialBtn && nextTestimonialBtn) {
      let currentTestimonial = 0;

      function showTestimonial(index) {
        // Esconder todos os slides
        testimonialSlides.forEach(slide => {
          slide.classList.add('hidden');
        });

        // Mostrar o slide atual
        testimonialSlides[index].classList.remove('hidden');

        // Atualizar dots
        testimonialDots.forEach((dot, i) => {
          if (i === index) {
            dot.classList.remove('bg-white/30', 'w-3');
            dot.classList.add('bg-indigo-600', 'w-8');
          } else {
            dot.classList.remove('bg-indigo-600', 'w-8');
            dot.classList.add('bg-white/30', 'w-3');
          }
        });

        currentTestimonial = index;
      }

      // Inicializar carrossel
      showTestimonial(0);

      prevTestimonialBtn.addEventListener('click', () => {
        const newIndex = currentTestimonial === 0 ? testimonialSlides.length - 1 : currentTestimonial - 1;
        showTestimonial(newIndex);
      });

      nextTestimonialBtn.addEventListener('click', () => {
        const newIndex = currentTestimonial === testimonialSlides.length - 1 ? 0 : currentTestimonial + 1;
        showTestimonial(newIndex);
      });

      testimonialDots.forEach((dot, index) => {
        dot.addEventListener('click', () => {
          showTestimonial(index);
        });
      });

      // Auto-play (opcional)
      setInterval(() => {
        const newIndex = currentTestimonial === testimonialSlides.length - 1 ? 0 : currentTestimonial + 1;
        showTestimonial(newIndex);
      }, 5000); // Muda a cada 5 segundos
    }
  </script>

  <style>
    .package-card {
      order: var(--package-order-mobile, 999999);
    }

    @media (min-width: 1024px) {
      .package-card {
        order: var(--package-order-desktop, var(--package-order-mobile, 999999));
      }
    }

    .scrollbar-hide::-webkit-scrollbar {
      display: none;
    }

    .scrollbar-hide {
      -ms-overflow-style: none;
      scrollbar-width: none;
    }

    @keyframes float {
      0%, 100% { transform: translateY(0px); }
      50% { transform: translateY(-20px); }
    }

    @keyframes blob {
      0%, 100% { transform: translate(0px, 0px) scale(1); }
      33% { transform: translate(30px, -50px) scale(1.1); }
      66% { transform: translate(-20px, 20px) scale(0.9); }
    }

    @keyframes bounce-x {
      0%, 100% { transform: translateX(0); }
      50% { transform: translateX(10px); }
    }

    .animate-float {
      animation: float 3s ease-in-out infinite;
    }

    .animate-float-delayed {
      animation: float 3s ease-in-out infinite;
      animation-delay: 1s;
    }

    .animate-blob {
      animation: blob 7s infinite;
    }

    .animate-bounce-x {
      animation: bounce-x 1s ease-in-out infinite;
    }

    .animation-delay-2000 {
      animation-delay: 2s;
    }
  </style>
</body>

</html>
