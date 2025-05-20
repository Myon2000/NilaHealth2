@extends('frontend.layouts.app')

@section('extraCSS')
<style>
    .article-content h2 {
        @apply text-2xl font-bold mt-8 mb-4 text-gray-800 dark:text-gray-200;
    }
    .article-content p {
        @apply mb-6 leading-relaxed text-gray-600 dark:text-gray-300;
    }
    .article-content img {
        @apply rounded-lg shadow-lg my-8 mx-auto;
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
</style>
@endsection

@section('content')
<div class="bg-gradient-to-b from-gray-50 to-white dark:from-gray-900 dark:to-gray-800 min-h-screen pt-20">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Article Header -->
        <div class="mb-8 animate-fade-up">
            <!-- Tag Badge -->
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium mb-4
                {{ $article->tag === 'penyakit' ? 'bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-200' : 
                   ($article->tag === 'perawatan' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-200' : 
                   'bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-200') }}">
                {{ ucfirst($article->tag) }}
            </span>

            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white mb-6 leading-tight">
                {{ $article->judul }}
            </h1>
            
            <!-- Author Info -->
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

        <!-- Article Content -->
        <article class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8 mb-12 animate-fade-up delay-100">
            <div class="prose dark:prose-invert max-w-none article-content">
                {!! $article->isi !!}
            </div>
        </article>

        <!-- Comment Section -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8 animate-fade-up delay-200">
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
    </div>
</div>
@endsection