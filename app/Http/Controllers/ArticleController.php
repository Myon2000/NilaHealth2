<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $query = Article::with(['author', 'comments'])
                        ->latest();

        if ($request->has('tag') && $request->tag !== 'semua') {
            $query->where('tag', $request->tag);
        }

        if ($request->has('search') && !empty(trim($request->search))) {
            $search = trim($request->search);
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                ->orWhere('isi', 'like', "%{$search}%");
            });
        }

        $articles = $query->paginate(9);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('frontend.pages.article._article_grid', compact('articles'))->render(),
                'pagination' => $articles->links()->toHtml()
            ]);
        }

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
            'users_id' => Auth::id(),
            'isi' => $validated['isi']
        ]);

        $article->comments()->save($comment);

        return back()->with('success', 'Komentar berhasil ditambahkan');
    }
}