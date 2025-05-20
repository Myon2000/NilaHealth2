@extends('frontend.layouts.app')

@section('meta')
<meta name="description" content="{{ Str::limit(strip_tags($article->isi), 160) }}">
<meta property="og:title" content="{{ $article->judul }}">
<meta property="og:description" content="{{ Str::limit(strip_tags($article->isi), 160) }}">
<meta property="og:type" content="article">
@endsection

@section('content')
<div class="bg-gray-50 dark:bg-gray-900 min-h-screen pt-20">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <article class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8 mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">{{ $article->judul }}</h1>
            
            <div class="flex items-center text-gray-500 dark:text-gray-400 mb-8">
                <span>Oleh {{ $article->author->name }}</span>
                <span class="mx-2">•</span>
                <span>{{ $article->created_at->format('d M Y') }}</span>
            </div>

            <div class="prose dark:prose-invert max-w-none">
                {!! $article->isi !!}
            </div>
        </article>

        <!-- Comment Section -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">Komentar</h3>

            @auth
            <form action="{{ route('comments.store', $article) }}" method="POST" class="mb-8">
                @csrf
                <div class="mb-4">
                    <textarea name="isi" rows="3" 
                        class="w-full px-3 py-2 text-gray-700 dark:text-gray-300 border rounded-lg focus:outline-none focus:border-blue-500 dark:border-gray-600 dark:bg-gray-700"
                        placeholder="Tulis komentar Anda..."></textarea>
                    @error('isi')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit" 
                    class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors duration-200">
                    Kirim Komentar
                </button>
            </form>
            @endauth

            <div class="space-y-6">
                @foreach($article->comments as $comment)
                <div class="flex space-x-4">
                    <div class="flex-1">
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                            <div class="flex items-center justify-between mb-2">
                                <span class="font-medium text-gray-900 dark:text-white">{{ $comment->user->name }}</span>
                                <span class="text-sm text-gray-500 dark:text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-gray-600 dark:text-gray-300">{{ $comment->isi }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection