<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, Article $article)
    {
        $validated = $request->validate([
            'isi' => 'required|string|min:3|max:1000'
        ]);

        $comment = Comment::create([
            'artikel_id' => $article->id,
            'users_id' => Auth::id(),
            'isi' => $validated['isi']
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Komentar berhasil ditambahkan',
                'comment' => $comment->load('user')
            ]);
        }

        return back()->with('success', 'Komentar berhasil ditambahkan');
    }

    public function destroy(Comment $comment)
    {
        if ($comment->users_id !== Auth::id()) { 
            return back()->with('error', 'Anda tidak memiliki izin untuk menghapus komentar ini');
        }

        $comment->delete();
        return back()->with('success', 'Komentar berhasil dihapus');
    }
}