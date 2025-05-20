@extends('admin.layouts.app')

@section('content')
<div class="container px-6 mx-auto grid">
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        Kelola Artikel
    </h2>

    <div class="flex justify-end mb-6">
        <a href="{{ route('admin.articles.create') }}" 
           class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors duration-200">
            Tambah Artikel
        </a>
    </div>

    <div class="w-full overflow-hidden rounded-lg shadow-xs">
        <div class="w-full overflow-x-auto">
            <table class="w-full whitespace-no-wrap">
                <thead>
                    <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                        <th class="px-4 py-3">Judul</th>
                        <th class="px-4 py-3">Tanggal</th>
                        <th class="px-4 py-3">Komentar</th>
                        <th class="px-4 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    @foreach($articles as $article)
                    <tr class="text-gray-700 dark:text-gray-400">
                        <td class="px-4 py-3">
                            <div class="flex items-center text-sm">
                                <div>
                                    <p class="font-semibold">{{ $article->judul }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-sm">
                            {{ $article->created_at->format('d M Y') }}
                        </td>
                        <td class="px-4 py-3 text-sm">
                            {{ $article->comments_count ?? 0 }}
                        </td>
                        <td class="px-4 py-3 text-sm">
                            <div class="flex items-center space-x-4">
                                <a href="{{ route('admin.articles.edit', $article) }}" 
                                   class="text-blue-600 hover:text-blue-800">
                                    Edit
                                </a>
                                <form action="{{ route('admin.articles.destroy', $article) }}" 
                                      method="POST" 
                                      onsubmit="return confirm('Yakin ingin menghapus artikel ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-4 py-3 border-t dark:border-gray-700">
            {{ $articles->links() }}
        </div>
    </div>
</div>
@endsection