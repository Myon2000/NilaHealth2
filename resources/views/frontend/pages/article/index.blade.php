@extends('frontend.layouts.app')

@section('extraCSS')
<style>
    .search-animation {
        animation: bounce 1s infinite;
    }
    @keyframes bounce {
        0%, 100% { transform: translateY(-5%); }
        50% { transform: translateY(0); }
    }
    .article-card {
        transition: all 0.3s ease;
    }
    .article-card:hover {
        transform: translateY(-5px) scale(1.01);
    }

    /* Existing animations */
    .search-animation {
        animation: bounce 1s infinite;
    }
    @keyframes bounce {
        0%, 100% { transform: translateY(-5%); }
        50% { transform: translateY(0); }
    }
    
    /* New animations for filtering */
    .article-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 2rem;
    }
    
    .article-item {
        transition: all 0.5s ease-in-out;
        transform-origin: center;
    }
    
    .article-item.hiding {
        opacity: 0;
        transform: scale(0.8);
    }
    
    .article-item.showing {
        animation: showItem 0.5s ease-in-out forwards;
    }
    
    @keyframes showItem {
        from {
            opacity: 0;
            transform: scale(0.8);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }
    
    .article-item.moving {
        transition: transform 0.5s ease-in-out;
    }
</style>
@endsection

@section('content')
<div class="bg-gradient-to-b from-gray-50 to-white dark:from-gray-900 dark:to-gray-800 min-h-screen pt-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header Section with Animation -->
        <div class="text-center mb-12">
            <h1 class="text-4xl md:text-5xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-purple-600 dark:from-blue-400 dark:to-purple-400 mb-4">
                Artikel Edukasi
            </h1>
            <p class="text-gray-600 dark:text-gray-300 text-lg max-w-2xl mx-auto">
                Temukan informasi menarik seputar budidaya ikan yang kekinian dan up-to-date
            </p>
        </div>
        
        <!-- Search and Filter Section -->
        <div class="mb-12 bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-lg">
            <div class="flex flex-col md:flex-row gap-6">
                <!-- Enhanced Search -->
                <div class="flex-1">
                    <form action="{{ route('articles.index') }}" method="GET" class="relative">
                        <input type="text" 
                            name="search" 
                            value="{{ request('search') }}"
                            placeholder="Cari artikel..." 
                            class="w-full pl-12 pr-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 focus:ring-2 focus:ring-blue-500 transition-all duration-300"
                        >
                        <!-- If there's a tag filter, preserve it -->
                        @if(request('tag') && request('tag') !== 'semua')
                            <input type="hidden" name="tag" value="{{ request('tag') }}">
                        @endif
                        <button type="submit" class="absolute right-3 top-3 text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </button>
                    </form>
                </div>
                
                <!-- Enhanced Tag Filters -->
                <div class="flex flex-wrap gap-3">
                    @foreach(['semua', 'penyakit', 'perawatan', 'budidaya'] as $tag)
                    <a href="{{ route('articles.index', ['tag' => $tag]) }}" 
                        class="px-6 py-3 rounded-xl font-medium transition-all duration-300 
                        {{ request('tag') === $tag 
                            ? 'bg-gradient-to-r from-blue-600 to-purple-600 text-white shadow-lg scale-105' 
                            : 'bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600' }}">
                        <span class="flex items-center">
                            @if($tag === 'penyakit')
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            @elseif($tag === 'perawatan')
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                </svg>
                            @elseif($tag === 'budidaya')
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                                </svg>
                            @endif
                            {{ ucfirst($tag) }}
                        </span>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Articles Grid -->
        <div id="articles-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($articles as $article)
            <article class="article-item article-card bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden" data-tag="{{ $article->tag }}">
                <div class="p-6">
                    <!-- Tag Badge -->
                    <div class="flex justify-between items-start mb-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                            {{ $article->tag === 'penyakit' ? 'bg-red-100 text-red-800' : 
                            ($article->tag === 'perawatan' ? 'bg-blue-100 text-blue-800' : 
                            'bg-green-100 text-green-800') }}">
                            {{ ucfirst($article->tag) }}
                        </span>
                        <span class="text-sm text-gray-500">{{ $article->created_at->diffForHumans() }}</span>
                    </div>
                    <a href="{{ route('articles.show', $article) }}" class="block group">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-3 line-clamp-2 group-hover:text-blue-600">
                            {{ $article->judul }}
                        </h2>
                        <p class="text-gray-600 dark:text-gray-300 mb-4 line-clamp-3">
                            {{ Str::limit(strip_tags($article->isi), 150) }}
                        </p>
                    </a>

                    <!-- Article Footer -->
                    <div class="flex items-center justify-between pt-4 border-t border-gray-100 dark:border-gray-700">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-r from-blue-500 to-purple-500 flex items-center justify-center text-white font-bold">
                                {{ substr($article->author->name, 0, 1) }}
                            </div>
                            <span class="text-sm text-gray-600 dark:text-gray-400">{{ $article->author->name }}</span>
                        </div>
                        <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                            </svg>
                            {{ $article->comments->count() }}
                        </div>
                    </div>
                </div>
            </article>
            @empty
            <div class="col-span-3 text-center py-12">
                <div class="w-24 h-24 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Belum ada artikel</h3>
                <p class="text-gray-500 dark:text-gray-400">Artikel yang kamu cari belum tersedia</p>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-12">
            {{ $articles->links() }}
        </div>
    </div>
</div>
@endsection

@section('extraJS')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.querySelector('input[name="search"]');
    const container = document.getElementById('articles-container');
    const paginationContainer = document.querySelector('.mt-12');
    let currentRequest = null;
    
    // Get initial active tag from URL
    let activeTag = new URLSearchParams(window.location.search).get('tag') || 'semua';

    // Handle tag filters
    document.querySelectorAll('[href*="articles.index"]').forEach(link => {
        link.addEventListener('click', async (e) => {
            e.preventDefault();
            const url = new URL(link.href);
            activeTag = url.searchParams.get('tag') || 'semua';
            
            updateActiveTag(link);
            await handleFilter(activeTag, searchInput.value.trim());
        });
    });

    // Handle search input with debounce
    searchInput.addEventListener('input', debounce(async () => {
        await handleFilter(activeTag, searchInput.value.trim());
    }, 300));

    async function handleFilter(tag, search = '') {
        try {
            if (currentRequest) {
                currentRequest.abort();
            }

            container.style.opacity = '0.5';
            
            // Preserve current URL parameters
            const url = new URL(window.location.href);
            
            // Update search parameter
            if (search) {
                url.searchParams.set('search', search);
            } else {
                url.searchParams.delete('search');
            }
            
            // Always maintain tag parameter if it's not 'semua'
            if (tag && tag !== 'semua') {
                url.searchParams.set('tag', tag);
            } else if (tag === 'semua') {
                url.searchParams.delete('tag');
            }

            const controller = new AbortController();
            currentRequest = controller;

            const response = await fetch(url.toString(), {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                signal: controller.signal
            });

            if (!response.ok) throw new Error('Network response was not ok');
            
            const data = await response.json();

            // Update content
            const currentArticles = container.querySelectorAll('.article-item');
            currentArticles.forEach(article => article.classList.add('hiding'));

            await new Promise(resolve => setTimeout(resolve, 300));

            container.innerHTML = data.html;
            if (data.pagination) {
                paginationContainer.innerHTML = data.pagination;
            }

            // Update URL preserving both search and tag
            window.history.pushState({}, '', url.toString());

            // Animate new articles
            const newArticles = container.querySelectorAll('.article-item');
            newArticles.forEach((article, index) => {
                article.style.opacity = '0';
                article.style.transform = 'translateY(20px)';
                
                setTimeout(() => {
                    article.style.transition = 'all 0.3s ease-in-out';
                    article.style.opacity = '1';
                    article.style.transform = 'translateY(0)';
                }, index * 50);
            });

        } catch (error) {
            if (error.name !== 'AbortError') {
                console.error('Error:', error);
            }
        } finally {
            container.style.opacity = '1';
            currentRequest = null;
        }
    }

    function updateActiveTag(activeLink) {
        document.querySelectorAll('[href*="articles.index"]').forEach(link => {
            link.classList.remove('from-blue-600', 'to-purple-600', 'text-white', 'shadow-lg', 'scale-105');
            link.classList.add('bg-gray-100', 'dark:bg-gray-700');
        });
        activeLink.classList.remove('bg-gray-100', 'dark:bg-gray-700');
        activeLink.classList.add('bg-gradient-to-r', 'from-blue-600', 'to-purple-600', 'text-white', 'shadow-lg', 'scale-105');
    }

    function debounce(func, wait) {
        let timeout;
        return function(...args) {
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(this, args), wait);
        };
    }
});
</script>
@endsection