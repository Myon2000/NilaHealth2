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
        
        // Format artikel untuk tampilan yang lebih baik
        $article->isi = $this->formatArticleContent($article->isi);
        
        // Cari artikel terkait berdasarkan tag
        $relatedArticles = Article::where('tag', $article->tag)
                                 ->where('id', '!=', $article->id)
                                 ->latest()
                                 ->take(3)
                                 ->get();
        
        return view('frontend.pages.article.show', compact('article', 'relatedArticles'));
    }

    /**
     * Format konten artikel untuk menampilkan paragraf dengan jelas
     *
     * @param string $content
     * @return string
     */
    private function formatArticleContent($content)
    {
        // Jika konten sudah berisi tag HTML, jangan format ulang
        if (strpos($content, '<p>') !== false) {
            return $content;
        }
        
        // Deteksi paragraf berdasarkan baris kosong
        $content = preg_replace('/\n\s*\n/', '</p><p>', $content);
        
        // Deteksi kalimat panjang (berakhiran titik, dll) sebagai paragraf terpisah
        // jika belum ada pembagian paragraf di dalam konten
        if (strpos($content, '</p><p>') === false) {
            $content = preg_replace('/(\.|!|\?)\s+(?=[A-Z])/', '$1</p><p>', $content);
        }
        
        // Pastikan konten dimulai dan diakhiri dengan tag paragraf
        $content = '<p>' . $content . '</p>';
        
        // Hapus tag paragraf kosong
        $content = str_replace(['<p></p>', '<p> </p>'], '', $content);
        
        return $content;
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