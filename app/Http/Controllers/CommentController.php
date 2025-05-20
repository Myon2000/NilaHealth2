<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Article; 
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Article $article)
    {
        $validated = $request->validate([
            'isi' => 'required|string|min:3|max:1000' // tambah max length
        ]);

        $comment = Comment::create([
            'artikel_id' => $article->id,
            'users_id' => auth()->id(),
            'isi' => $validated['isi']
        ]);

        // Jika request adalah AJAX
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Komentar berhasil ditambahkan',
                'comment' => $comment->load('user') // Load relasi user untuk response
            ]);
        }

        return back()->with('success', 'Komentar berhasil ditambahkan');
    }

    public function destroy(Comment $comment)
    {
        // Pastikan user yang menghapus adalah pemilik komentar
        if ($comment->users_id !== auth()->id()) {
            return back()->with('error', 'Anda tidak memiliki izin untuk menghapus komentar ini');
        }

        $comment->delete();
        return back()->with('success', 'Komentar berhasil dihapus');
    }
}