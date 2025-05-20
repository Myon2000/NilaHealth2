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

        <!-- Article Content -->
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