<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::with('author')
            ->withCount('comments')
            ->latest()
            ->paginate(10);
            
        return view('admin.pages.article.index', compact('articles'));
    }

    public function create()
    {
        return view('admin.pages.article.store');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255|unique:artikel',
            'isi' => 'required|string|min:100',
            'tag' => 'required|in:penyakit,perawatan,budidaya'
        ]);

        Article::create([
            ...$validated,
            'users_id' => Auth::id()
        ]);

        return redirect()
            ->route('admin.articles.index')
            ->with('success', 'Artikel berhasil ditambahkan');
    }

    public function edit(Article $article)
    {
        return view('admin.pages.article.update', compact('article'));
    }

    public function update(Request $request, Article $article)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255|unique:artikel,judul,' . $article->id,
            'isi' => 'required|string|min:100',
            'tag' => 'required|in:penyakit,perawatan,budidaya'
        ]);

        try {
            $article->update($validated);
            
            return redirect()
                ->route('admin.articles.index')
                ->with('success', 'Artikel berhasil diperbarui');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Gagal memperbarui artikel');
        }
    }

    public function destroy(Article $article)
    {
        try {
            $article->comments()->delete();
            
            $article->delete();
            
            return redirect()
                ->route('admin.articles.index')
                ->with('success', 'Artikel berhasil dihapus');
                
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.articles.index')
                ->with('error', 'Gagal menghapus artikel');
        }
    }
}