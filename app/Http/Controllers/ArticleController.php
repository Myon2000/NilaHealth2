<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::with('author')
            ->latest()
            ->paginate(10);
            
        return view('frontend.pages.article.index', compact('articles'));
    }

    public function show(Article $article)
    {
        $article->load(['comments.user', 'author']);
        return view('frontend.pages.article.show', compact('article'));
    }

    public function storeComment(Request $request, Article $article)
    {
        $validated = $request->validate([
            'isi' => 'required|string|min:3'
        ]);

        $comment = new Comment([
            'users_id' => auth()->id(),
            'isi' => $validated['isi']
        ]);

        $article->comments()->save($comment);

        return back()->with('success', 'Komentar berhasil ditambahkan');
    }
}