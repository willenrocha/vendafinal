<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Pagamento Confirmado! - {{ config('app.name', 'Laravel') }}</title>

  @vite(['resources/css/app.css', 'resources/js/app.js'])

  <style>
    @keyframes check-scale {
      0%, 100% { transform: scale(1); }
      50% { transform: scale(1.1); }
    }
    .animate-check-scale {
      animation: check-scale 0.6s ease-in-out;
    }
    @keyframes fade-in-up {
      from {
        opacity: 0;
        transform: translateY(20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
    .animate-fade-in-up {
      animation: fade-in-up 0.8s ease-out forwards;
    }
  </style>
</head>

<body class="bg-gray-50 antialiased">
  @php
    /** @var \App\Models\Order $order */
    $formatMoney = fn ($value) => 'R$ ' . number_format((float) $value, 2, ',', '.');

    $packageName = (string) ($package?->name ?? data_get($order->package_snapshot, 'name', ''));
    $amount = $formatMoney($order->amount);
    $publicCode = (string) ($order->public_code ?? '');
    $customerName = (string) ($order->customer_name ?? '');
    $customerEmail = (string) ($order->customer_email ?? '');

    $whatsUrl = (string) config('services.whatsapp.engajamento_inteligente_url', '');
    if ($whatsUrl === '') {
      $text = rawurlencode('Olá! Acabei de fazer um pedido (' . $publicCode . ') e quero saber mais sobre o Engajamento Inteligente.');
      $whatsUrl = 'https://wa.me/5500000000000?text=' . $text;
    }
  @endphp

  <main class="min-h-screen bg-gradient-to-br from-green-50 via-emerald-50 to-teal-50">
  <main class="min-h-screen bg-gradient-to-br from-green-50 via-emerald-50 to-teal-50">
    <!-- Hero Section com Confirmação -->
    <section class="relative overflow-hidden">
      <!-- Background decorativo -->
      <div class="absolute inset-0 overflow-hidden">
        <div class="absolute top-0 right-0 w-96 h-96 bg-green-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-pulse"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-emerald-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-pulse" style="animation-delay: 1s;"></div>
      </div>

      <div class="relative max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-24">
        <!-- Ícone de sucesso animado -->
        <div class="flex justify-center mb-8 animate-fade-in-up">
          <div class="relative">
            <div class="absolute inset-0 bg-green-400 rounded-full blur-2xl opacity-40 animate-pulse"></div>
            <div class="relative w-24 h-24 bg-gradient-to-br from-green-500 to-emerald-600 rounded-full flex items-center justify-center shadow-2xl animate-check-scale">
              <svg class="w-14 h-14 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
              </svg>
            </div>
          </div>
        </div>

        <!-- Título Principal -->
        <div class="text-center space-y-4 mb-12 animate-fade-in-up" style="animation-delay: 0.2s;">
          <div class="inline-flex items-center gap-2 px-4 py-2 bg-white rounded-full shadow-md">
            <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
            <span class="text-sm font-semibold text-gray-700">Pagamento Confirmado</span>
          </div>

          <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-gray-900 leading-tight">
            Tudo certo, <br class="sm:hidden">
            <span class="bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent">
              {{ explode(' ', $customerName)[0] ?? 'Cliente' }}!
            </span>
          </h1>

          <p class="text-lg sm:text-xl text-gray-600 max-w-2xl mx-auto">
            Seu pagamento foi confirmado com sucesso e já iniciamos o processamento do seu pedido.
          </p>
        </div>

        <!-- Card de Detalhes do Pedido -->
        <div class="max-w-3xl mx-auto mb-12 animate-fade-in-up" style="animation-delay: 0.4s;">
          <div class="bg-white rounded-3xl shadow-2xl border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-green-500 to-emerald-600 px-8 py-6">
              <h2 class="text-2xl font-bold text-white">Detalhes do Pedido</h2>
            </div>

            <div class="p-8 space-y-6">
              <div class="grid sm:grid-cols-2 gap-6">
                <div class="space-y-2">
                  <p class="text-sm font-medium text-gray-500">Código do Pedido</p>
                  <div class="flex items-center gap-2">
                    <p class="text-2xl font-bold text-gray-900">{{ $publicCode }}</p>
                    <button onclick="navigator.clipboard.writeText('{{ $publicCode }}')" class="p-2 hover:bg-gray-100 rounded-lg transition">
                      <svg class="w-5 h-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                      </svg>
                    </button>
                  </div>
                </div>

                <div class="space-y-2">
                  <p class="text-sm font-medium text-gray-500">Valor Total</p>
                  <p class="text-2xl font-bold text-green-600">{{ $amount }}</p>
                </div>
              </div>

              <div class="pt-6 border-t border-gray-200">
                <div class="flex items-start gap-4">
                  <div class="w-12 h-12 bg-gradient-to-br from-green-100 to-emerald-100 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                  </div>
                  <div class="flex-1">
                    <p class="text-sm font-medium text-gray-500">Pacote Adquirido</p>
                    <p class="text-lg font-bold text-gray-900 mt-1">{{ $packageName }}</p>
                  </div>
                </div>
              </div>

              <div class="pt-6 border-t border-gray-200">
                <div class="flex items-start gap-4">
                  <div class="w-12 h-12 bg-gradient-to-br from-blue-100 to-indigo-100 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                  </div>
                  <div class="flex-1">
                    <p class="text-sm font-medium text-gray-500">Confirmação enviada para</p>
                    <p class="text-lg font-semibold text-gray-900 mt-1">{{ $customerEmail }}</p>
                    <p class="text-xs text-gray-500 mt-1">Verifique sua caixa de entrada e spam</p>
                  </div>
                </div>
              </div>

              <div class="pt-6 border-t border-gray-200">
                <a href="#" class="group flex items-center justify-between gap-4 p-4 bg-gradient-to-r from-indigo-50 to-purple-50 hover:from-indigo-100 hover:to-purple-100 rounded-2xl transition">
                  <div class="flex items-start gap-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center flex-shrink-0">
                      <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                      </svg>
                    </div>
                    <div class="flex-1">
                      <p class="text-sm font-medium text-gray-700">Acompanhe em tempo real</p>
                      <p class="text-lg font-bold text-gray-900 mt-0.5">Acesse seu Painel do Cliente</p>
                      <p class="text-xs text-gray-600 mt-1">Visualize o progresso do seu pedido e histórico completo</p>
                    </div>
                  </div>
                  <svg class="w-6 h-6 text-indigo-600 group-hover:translate-x-1 transition-transform flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                  </svg>
                </a>
              </div>
            </div>
          </div>
        </div>

        <!-- Banner Engajamento Inteligente -->
        <div class="max-w-5xl mx-auto mt-12 animate-fade-in-up" style="animation-delay: 0.5s;">
          <div class="relative overflow-hidden bg-gradient-to-br from-purple-600 via-indigo-600 to-blue-600 rounded-3xl shadow-2xl">
            <!-- Background Pattern -->
            <div class="absolute inset-0 opacity-10">
              <div class="absolute top-0 left-0 w-full h-full" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 40px 40px;"></div>
            </div>
            <div class="absolute top-0 right-0 w-96 h-96 bg-purple-500 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-pulse"></div>
            <div class="absolute bottom-0 left-0 w-96 h-96 bg-blue-500 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-pulse" style="animation-delay: 2s;"></div>

            <div class="relative px-8 py-10 sm:p-12">
              <div class="flex flex-col lg:flex-row items-center gap-8">
                <!-- Conteúdo -->
                <div class="flex-1 text-center lg:text-left">
                  <div class="inline-flex items-center gap-2 px-4 py-2 bg-white/20 backdrop-blur-sm rounded-full mb-4">
                    <svg class="w-4 h-4 text-yellow-300" fill="currentColor" viewBox="0 0 20 20">
                      <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>
                    <span class="text-sm font-bold text-white">Produto Exclusivo</span>
                  </div>

                  <h2 class="text-3xl sm:text-4xl font-extrabold text-white mb-3">
                    Engajamento Inteligente
                  </h2>
                  <p class="text-lg text-purple-100 mb-4 leading-relaxed">
                    Revolucione seu perfil com <span class="font-bold text-white">acompanhamento por IA</span> e engajamento em tempo real. Resultados consistentes e crescimento acelerado.
                  </p>

                  <ul class="space-y-3 mb-6">
                    <li class="flex items-center gap-3 text-white">
                      <div class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                      </div>
                      <span class="font-medium">Análise inteligente do seu perfil 24/7</span>
                    </li>
                    <li class="flex items-center gap-3 text-white">
                      <div class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                      </div>
                      <span class="font-medium">Engajamento automático e estratégico</span>
                    </li>
                    <li class="flex items-center gap-3 text-white">
                      <div class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                      </div>
                      <span class="font-medium">Disponível apenas via WhatsApp</span>
                    </li>
                  </ul>

                  <a href="{{ $whatsUrl }}" target="_blank" rel="noopener"
                     class="inline-flex items-center gap-3 px-8 py-4 bg-white hover:bg-gray-50 rounded-2xl font-bold text-lg text-purple-600 shadow-2xl hover:shadow-xl transition-all transform hover:scale-105">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                      <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                    </svg>
                    <span>Quero saber mais</span>
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                  </a>
                </div>

                <!-- Ilustração -->
                <div class="flex-shrink-0 lg:w-64">
                  <div class="relative">
                    <div class="absolute inset-0 bg-gradient-to-br from-purple-400 to-blue-400 rounded-3xl blur-2xl opacity-50"></div>
                    <div class="relative bg-white/10 backdrop-blur-sm rounded-3xl p-8 border border-white/20">
                      <div class="space-y-4">
                        <div class="flex items-center gap-3">
                          <div class="w-12 h-12 bg-gradient-to-br from-green-400 to-emerald-500 rounded-xl animate-pulse"></div>
                          <div class="flex-1 space-y-2">
                            <div class="h-3 bg-white/40 rounded-full w-3/4"></div>
                            <div class="h-3 bg-white/20 rounded-full w-1/2"></div>
                          </div>
                        </div>
                        <div class="flex items-center gap-3">
                          <div class="w-12 h-12 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-xl animate-pulse" style="animation-delay: 0.3s;"></div>
                          <div class="flex-1 space-y-2">
                            <div class="h-3 bg-white/40 rounded-full w-2/3"></div>
                            <div class="h-3 bg-white/20 rounded-full w-3/4"></div>
                          </div>
                        </div>
                        <div class="flex items-center gap-3">
                          <div class="w-12 h-12 bg-gradient-to-br from-purple-400 to-pink-500 rounded-xl animate-pulse" style="animation-delay: 0.6s;"></div>
                          <div class="flex-1 space-y-2">
                            <div class="h-3 bg-white/40 rounded-full w-1/2"></div>
                            <div class="h-3 bg-white/20 rounded-full w-2/3"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Próximos Passos -->
        <div class="max-w-5xl mx-auto mt-12 animate-fade-in-up" style="animation-delay: 0.6s;">
          <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-gray-900">O que acontece agora?</h2>
            <p class="text-gray-600 mt-2">Acompanhe as próximas etapas do seu pedido</p>
          </div>

          <div class="grid md:grid-cols-3 gap-6">
            <div class="relative group">
              <div class="absolute inset-0 bg-gradient-to-r from-green-500 to-emerald-500 rounded-2xl blur opacity-25 group-hover:opacity-40 transition"></div>
              <div class="relative bg-white rounded-2xl p-6 shadow-xl">
                <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center mb-4">
                  <span class="text-2xl font-bold text-white">1</span>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Verificação</h3>
                <p class="text-gray-600 text-sm leading-relaxed">
                  Validamos os dados do seu perfil e confirmamos todos os detalhes do pedido.
                </p>
              </div>
            </div>

            <div class="relative group">
              <div class="absolute inset-0 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-2xl blur opacity-25 group-hover:opacity-40 transition"></div>
              <div class="relative bg-white rounded-2xl p-6 shadow-xl">
                <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center mb-4">
                  <span class="text-2xl font-bold text-white">2</span>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Processamento</h3>
                <p class="text-gray-600 text-sm leading-relaxed">
                  Iniciamos a entrega gradual do serviço contratado com segurança e qualidade.
                </p>
              </div>
            </div>

            <div class="relative group">
              <div class="absolute inset-0 bg-gradient-to-r from-purple-500 to-pink-500 rounded-2xl blur opacity-25 group-hover:opacity-40 transition"></div>
              <div class="relative bg-white rounded-2xl p-6 shadow-xl">
                <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl flex items-center justify-center mb-4">
                  <span class="text-2xl font-bold text-white">3</span>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Acompanhamento</h3>
                <p class="text-gray-600 text-sm leading-relaxed">
                  Você recebe atualizações por e-mail sobre o progresso do seu pedido.
                </p>
              </div>
            </div>
          </div>
        </div>

        <!-- CTA Suporte -->
        <div class="max-w-4xl mx-auto mt-16 animate-fade-in-up" style="animation-delay: 0.8s;">
          <div class="relative overflow-hidden bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 rounded-3xl shadow-2xl">
            <div class="absolute inset-0 bg-gradient-to-br from-green-500/20 to-emerald-500/20"></div>
            <div class="absolute top-0 right-0 w-64 h-64 bg-green-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20"></div>

            <div class="relative px-8 py-12 sm:p-16">
              <div class="flex flex-col lg:flex-row items-center gap-8">
                <div class="flex-1 text-center lg:text-left">
                  <div class="inline-flex items-center gap-2 px-3 py-1 bg-green-500/20 rounded-full mb-4">
                    <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                    <span class="text-sm font-semibold text-green-400">Suporte Disponível</span>
                  </div>

                  <h2 class="text-3xl sm:text-4xl font-bold text-white mb-4">
                    Tem dúvidas sobre seu pedido?
                  </h2>
                  <p class="text-gray-300 text-lg">
                    Nossa equipe está pronta para te atender e esclarecer qualquer questão sobre o processamento do seu pedido.
                  </p>
                </div>

                <div class="flex-shrink-0">
                  <a href="{{ $whatsUrl }}" target="_blank" rel="noopener"
                     class="group inline-flex items-center gap-3 px-8 py-5 bg-green-500 hover:bg-green-600 rounded-2xl font-bold text-lg text-white shadow-2xl shadow-green-500/50 hover:shadow-green-500/70 transition-all transform hover:scale-105">
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                      <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                    </svg>
                    <span>Falar no WhatsApp</span>
                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Footer com botão voltar -->
        <div class="text-center mt-12 animate-fade-in-up" style="animation-delay: 1s;">
          <a href="/" class="inline-flex items-center gap-2 px-6 py-3 bg-white hover:bg-gray-50 rounded-xl text-gray-700 font-semibold shadow-lg hover:shadow-xl transition">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Voltar para a página inicial
          </a>
        </div>
      </div>
    </section>
  </main>
</body>

</html>
