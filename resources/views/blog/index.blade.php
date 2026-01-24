<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Blog - {{ config('app.name') }}</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-inter">

  <!-- Navbar -->
  <nav class="bg-white border-b border-gray-200 sticky top-0 z-50 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center h-16">
        <a href="/" class="flex items-center space-x-3">
          <div class="w-10 h-10 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-lg flex items-center justify-center">
            <span class="text-white font-bold text-xl">V</span>
          </div>
          <span class="text-xl font-bold text-gray-900">VendaFinal</span>
        </a>

        <div class="flex items-center space-x-4">
          <a href="/" class="text-gray-600 hover:text-indigo-600 transition-colors">Início</a>
          <a href="/#pacotes" class="text-gray-600 hover:text-indigo-600 transition-colors">Pacotes</a>
          <a href="{{ route('blog.index') }}" class="text-indigo-600 font-semibold">Blog</a>
        </div>
      </div>
    </div>
  </nav>

  <!-- Hero do Blog -->
  <section class="bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-500 py-16 lg:py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
      <h1 class="text-4xl lg:text-6xl font-extrabold text-white mb-6">
        Nosso Blog
      </h1>
      <p class="text-xl text-purple-100 max-w-2xl mx-auto">
        Dicas, estratégias e novidades para você crescer no Instagram
      </p>
    </div>
  </section>

  <!-- Busca e Filtros -->
  <section class="bg-white border-b border-gray-200 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <form method="GET" action="{{ route('blog.index') }}" class="flex flex-col md:flex-row gap-4">
        <div class="flex-1">
          <input
            type="text"
            name="search"
            value="{{ request('search') }}"
            placeholder="Buscar posts..."
            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
          >
        </div>

        <select
          name="category"
          onchange="this.form.submit()"
          class="px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
        >
          <option value="">Todas as Categorias</option>
          @foreach($categories as $cat)
            <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>
              {{ $cat }}
            </option>
          @endforeach
        </select>

        <button
          type="submit"
          class="px-6 py-3 bg-indigo-600 text-white rounded-lg font-semibold hover:bg-indigo-700 transition-colors"
        >
          Buscar
        </button>
      </form>
    </div>
  </section>

  <!-- Grid de Posts -->
  <section class="py-16 lg:py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

      @if($posts->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 lg:gap-10 mb-12">
          @foreach($posts as $post)
            <article class="bg-white rounded-2xl overflow-hidden border border-gray-100 hover:shadow-xl transition-all duration-300 group">
              <a href="{{ route('blog.show', $post->slug) }}">
                @if($post->featured_image)
                  <div class="relative overflow-hidden aspect-[16/10]">
                    <img
                      src="{{ Storage::url($post->featured_image) }}"
                      alt="{{ $post->title }}"
                      class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                    >
                    @if($post->category)
                      <div class="absolute top-4 left-4">
                        <span class="bg-indigo-600 text-white px-3 py-1 rounded-full text-xs font-semibold">
                          {{ $post->category }}
                        </span>
                      </div>
                    @endif
                  </div>
                @endif

                <div class="p-6 lg:p-8">
                  <div class="flex items-center space-x-4 text-sm text-gray-500 mb-4">
                    <time datetime="{{ $post->published_at?->toDateString() }}">
                      {{ $post->formatted_published_at }}
                    </time>
                    @if($post->reading_time)
                      <span>•</span>
                      <span>{{ $post->reading_time_text }}</span>
                    @endif
                  </div>

                  <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-indigo-600 transition-colors line-clamp-2">
                    {{ $post->title }}
                  </h3>

                  @if($post->excerpt)
                    <p class="text-gray-600 leading-relaxed mb-6 line-clamp-3">
                      {{ $post->excerpt }}
                    </p>
                  @endif

                  <div class="inline-flex items-center text-indigo-600 font-semibold hover:text-indigo-700 transition-colors">
                    Ler mais
                    <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                  </div>
                </div>
              </a>
            </article>
          @endforeach
        </div>

        <!-- Paginação -->
        <div class="mt-12">
          {{ $posts->links() }}
        </div>
      @else
        <div class="text-center py-16">
          <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
          </div>
          <h3 class="text-xl font-bold text-gray-900 mb-2">Nenhum post encontrado</h3>
          <p class="text-gray-600">Tente ajustar os filtros ou volte mais tarde.</p>
        </div>
      @endif

    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-gray-900 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
      <p class="text-gray-400">© {{ date('Y') }} VendaFinal. Todos os direitos reservados.</p>
    </div>
  </footer>

</body>
</html>
