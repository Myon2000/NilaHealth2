@extends('frontend.layouts.app')

@section('extraCSS')
<style>
    /* Enhanced Article Typography */
    .article-content h2 {
        @apply text-2xl font-bold mt-8 mb-4 text-gray-800 dark:text-gray-200;
    }
    
    .article-content h3 {
        @apply text-xl font-bold mt-6 mb-3 text-gray-800 dark:text-gray-200;
    }
    
    .article-content p {
        @apply mb-6 leading-relaxed text-gray-600 dark:text-gray-300 text-base sm:text-lg;
        display: block; /* Memastikan selalu block */
        text-indent: 1em; /* Indentasi awal paragraf */
        text-align: justify; /* Rata kanan-kiri */
        max-width: 100%; /* Mencegah overflow */
        overflow-wrap: break-word; /* Handling kata panjang */
        line-height: 1.75;
        margin-bottom: 1.5rem;
    }
    
    .article-content ul, .article-content ol {
        @apply mb-6 pl-6 text-gray-600 dark:text-gray-300;
    }
    
    .article-content ul {
        @apply list-disc;
    }
    
    .article-content ol {
        @apply list-decimal;
    }
    
    .article-content li {
        @apply mb-2;
    }
    
    .article-content a {
        @apply text-blue-600 dark:text-blue-400 hover:underline;
    }
    
    .article-content blockquote {
        @apply border-l-4 border-blue-500 pl-4 py-2 my-6 bg-blue-50 dark:bg-blue-900/30 rounded-r-lg italic text-gray-700 dark:text-gray-300;
    }
    
    .article-content img {
        @apply rounded-lg shadow-lg my-8 mx-auto max-w-full h-auto;
    }
    
    .article-content figure {
        @apply my-8;
    }
    
    .article-content figcaption {
        @apply text-center text-sm text-gray-500 dark:text-gray-400 mt-2;
    }
    
    .article-content pre {
        @apply bg-gray-100 dark:bg-gray-800 p-4 rounded-lg overflow-x-auto my-6;
    }
    
    .article-content code {
        @apply bg-gray-100 dark:bg-gray-800 px-1 py-0.5 rounded text-sm;
    }
    
    .article-content table {
        @apply w-full border-collapse my-6;
    }
    
    .article-content th {
        @apply bg-gray-100 dark:bg-gray-700 text-left p-2 border border-gray-200 dark:border-gray-700;
    }
    
    .article-content td {
        @apply p-2 border border-gray-200 dark:border-gray-700;
    }
    
    /* Memastikan batas antar-paragraf terlihat jelas */
    .article-content p + p {
        margin-top: 1em;
        border-top: 1px solid rgba(229, 231, 235, 0.3);
        padding-top: 1em;
    }
    
    /* Hindari CSS terputus di akhir artikel */
    .article-content > *:last-child {
        margin-bottom: 0 !important;
        padding-bottom: 0 !important;
    }
    
    .article-content::after {
        content: "";
        display: block;
        clear: both;
        height: 1px;
    }
    
    /* Improved spacing for mobile */
    @media (max-width: 640px) {
        .article-content h2 {
            @apply text-xl mt-6 mb-3;
        }
        
        .article-content p {
            @apply text-base mb-4;
            text-align: left; /* Lebih baik untuk mobile */
        }
        
        .article-content img {
            @apply my-4;
        }
    }
    
    .animate-fade-up {
        animation: fadeUp 0.5s ease-out forwards;
    }
    
    @keyframes fadeUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    /* Fixed grid for related articles */
    .articles-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 1.5rem;
    }
    
    /* Improved mobile comment display */
    @media (max-width: 640px) {
        .comment-container {
            margin-left: 0;
        }
    }
</style>
@endsection

@section('content')
<div class="bg-gradient-to-b from-gray-50 to-white dark:from-gray-900 dark:to-gray-800 min-h-screen pt-20">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-8 animate-fade-up">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium mb-4
                {{ $article->tag === 'penyakit' ? 'bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-200' : 
                   ($article->tag === 'perawatan' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-200' : 
                   'bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-200') }}">
                {{ ucfirst($article->tag) }}
            </span>

            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white mb-6 leading-tight">
                {{ $article->judul }}
            </h1>
            
            <div class="flex items-center space-x-4 mb-8">
                <div class="w-12 h-12 rounded-full bg-gradient-to-r from-blue-500 to-purple-500 flex items-center justify-center text-white font-bold text-xl">
                    {{ substr($article->author->name, 0, 1) }}
                </div>
                <div>
                    <div class="font-medium text-gray-900 dark:text-white">{{ $article->author->name }}</div>
                    <div class="flex items-center text-sm text-gray-500 dark:text-gray-400 space-x-2">
                        <span>{{ $article->created_at->format('d M Y') }}</span>
                        <span>•</span>
                        <span>{{ $article->created_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enhanced Article Content Display -->
        <article class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 sm:p-8 mb-12 animate-fade-up delay-100">
            <!-- Article featured image if available -->
            @if($article->featured_image)
            <div class="mb-8 -mx-6 sm:-mx-8 -mt-6 sm:-mt-8">
                <img src="{{ asset($article->featured_image) }}" 
                     alt="{{ $article->judul }}" 
                     class="w-full h-auto object-cover rounded-t-2xl max-h-96">
            </div>
            @endif
            
            <!-- Structured article content with improved typography -->
            <div class="prose prose-lg dark:prose-invert max-w-none article-content">
                @php
                    // Fall-back formatting jika ada masalah dengan pemformatan controller
                    $content = $article->isi;
                    if (strpos($content, '<p>') === false) {
                        // Deteksi paragraf berdasarkan baris kosong
                        $paragraphs = preg_split('/\n\s*\n/', $content);
                        $formattedContent = '';
                        
                        foreach ($paragraphs as $paragraph) {
                            if (!empty(trim($paragraph))) {
                                $formattedContent .= '<p>' . trim($paragraph) . '</p>';
                            }
                        }
                        
                        // Jika tidak ada paragraf terdeteksi, coba deteksi kalimat
                        if (count($paragraphs) <= 1) {
                            $sentences = preg_split('/(?<=[.!?])\s+(?=[A-Z])/', $content);
                            if (count($sentences) > 1) {
                                $formattedContent = '';
                                $currentParagraph = '';
                                $sentenceCount = 0;
                                
                                foreach ($sentences as $sentence) {
                                    $currentParagraph .= $sentence . ' ';
                                    $sentenceCount++;
                                    
                                    // Setiap 2-3 kalimat jadikan satu paragraf
                                    if ($sentenceCount >= 2 && (strpos($sentence, '.') !== false || strpos($sentence, '!') !== false || strpos($sentence, '?') !== false)) {
                                        $formattedContent .= '<p>' . trim($currentParagraph) . '</p>';
                                        $currentParagraph = '';
                                        $sentenceCount = 0;
                                    }
                                }
                                
                                // Tambahkan sisa kalimat sebagai paragraf terakhir
                                if (!empty(trim($currentParagraph))) {
                                    $formattedContent .= '<p>' . trim($currentParagraph) . '</p>';
                                }
                            }
                        }
                        
                        // Jika masih belum ada paragraf terdeteksi, gunakan konten asli
                        if (empty(trim($formattedContent))) {
                            $formattedContent = '<p>' . $content . '</p>';
                        }
                        
                        // Gunakan hasil pemformatan
                        $content = $formattedContent;
                    }
                @endphp
                
                {!! $content !!}
            </div>
            
            <!-- Article tags/keywords -->
            @if(isset($article->keywords) && !empty($article->keywords))
            <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                <div class="flex flex-wrap gap-2">
                    @foreach(explode(',', $article->keywords) as $keyword)
                    <span class="px-3 py-1 bg-gray-100 dark:bg-gray-700 rounded-full text-sm text-gray-700 dark:text-gray-300">
                        {{ trim($keyword) }}
                    </span>
                    @endforeach
                </div>
            </div>
            @endif
        </article>

        <!-- Comments Section with improved mobile layout -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 sm:p-8 animate-fade-up delay-200">
            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-8 flex items-center">
                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                </svg>
                Komentar ({{ $article->comments->count() }})
            </h3>

            @auth
            <form action="{{ route('comments.store', $article) }}" method="POST" class="mb-8">
                @csrf
                <div class="mb-4">
                    <textarea name="isi" rows="3" 
                        class="w-full px-4 py-3 text-gray-700 dark:text-gray-300 border rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:border-gray-600 dark:bg-gray-700"
                        placeholder="Tulis komentar Anda..."></textarea>
                    @error('isi')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit" 
                    class="inline-flex items-center px-6 py-3 rounded-xl bg-gradient-to-r from-blue-600 to-purple-600 text-white font-medium hover:from-blue-700 hover:to-purple-700 transition-all duration-200 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                    </svg>
                    Kirim Komentar
                </button>
            </form>
            @else
            <div class="text-center py-8 bg-gray-50 dark:bg-gray-700 rounded-xl mb-8">
                <p class="text-gray-600 dark:text-gray-300 mb-4">Login untuk memberikan komentar</p>
                <a href="{{ route('login') }}" 
                   class="inline-flex items-center px-6 py-3 rounded-xl bg-blue-600 text-white font-medium hover:bg-blue-700 transition-all duration-200">
                    Masuk
                </a>
            </div>
            @endauth

            <div class="space-y-6">
                @forelse($article->comments as $comment)
                <div class="flex space-x-4 animate-fade-up" style="animation-delay: {{ $loop->iteration * 100 }}ms">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-500 to-purple-500 flex-shrink-0 flex items-center justify-center text-white font-medium">
                        {{ substr($comment->user->name, 0, 1) }}
                    </div>
                    <div class="flex-1">
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-xl p-4">
                            <div class="flex items-center justify-between mb-2">
                                <span class="font-medium text-gray-900 dark:text-white">{{ $comment->user->name }}</span>
                                <span class="text-sm text-gray-500 dark:text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-gray-600 dark:text-gray-300">{{ $comment->isi }}</p>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center text-gray-500 dark:text-gray-400 py-8">
                    Belum ada komentar
                </div>
                @endforelse
            </div>
        </div>
        
        <!-- Related articles section -->
        @if(isset($relatedArticles) && count($relatedArticles) > 0)
        <div class="mt-12">
            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">
                Artikel Terkait
            </h3>
            
            <div class="articles-grid">
                @foreach($relatedArticles as $related)
                <a href="{{ route('articles.show', $related) }}" class="block group">
                    <div class="bg-white dark:bg-gray-800 rounded-xl overflow-hidden shadow-md hover:shadow-lg transition-all duration-300">
                        @if($related->featured_image)
                        <div class="h-48 overflow-hidden">
                            <img src="{{ asset($related->featured_image) }}" 
                                alt="{{ $related->judul }}"
                                class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-300">
                        </div>
                        @endif
                        <div class="p-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                {{ $related->tag === 'penyakit' ? 'bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-200' : 
                                   ($related->tag === 'perawatan' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-200' : 
                                   'bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-200') }}">
                                {{ ucfirst($related->tag) }}
                            </span>
                            <h4 class="mt-2 text-lg font-semibold text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 line-clamp-2">
                                {{ $related->judul }}
                            </h4>
                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400 line-clamp-3">
                                {{ Str::limit(strip_tags($related->isi), 100) }}
                            </p>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
@endsection