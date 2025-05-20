@extends('frontend.layouts.app')

@section('content')
<div class="bg-gray-50 dark:bg-gray-900 min-h-screen pt-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-8">Artikel Edukasi</h1>
        
        <div class="mb-8">
            <div class="flex flex-col md:flex-row gap-4">
                <!-- Search -->
                <div class="flex-1">
                    <form action="{{ route('articles.index') }}" method="GET">
                        <input type="text" 
                            name="search" 
                            value="{{ request('search') }}"
                            placeholder="Cari artikel..." 
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600">
                    </form>
                </div>
                
                <!-- Filter by Tag -->
                <div class="flex gap-2">
                    @foreach(['semua', 'penyakit', 'perawatan', 'budidaya'] as $tag)
                    <a href="{{ route('articles.index', ['tag' => $tag]) }}" 
                    class="px-4 py-2 rounded-lg {{ request('tag') === $tag ? 'bg-blue-600 text-white' : 'bg-gray-100 dark:bg-gray-700' }}">
                        {{ ucfirst($tag) }}
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($articles as $article)
            <article class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                <div class="p-6">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">
                        <a href="{{ route('articles.show', $article) }}" class="hover:text-blue-600 dark:hover:text-blue-400">
                            {{ $article->judul }}
                        </a>
                    </h2>
                    <p class="text-gray-600 dark:text-gray-300 mb-4">
                        {{ Str::limit(strip_tags($article->isi), 150) }}
                    </p>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-500 dark:text-gray-400">
                            {{ $article->created_at->diffForHumans() }}
                        </span>
                        <span class="text-sm text-gray-500 dark:text-gray-400">
                            {{ $article->comments->count() }} komentar
                        </span>
                    </div>
                </div>
            </article>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $articles->links() }}
        </div>
    </div>
</div>
@endsection