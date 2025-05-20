<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use App\Models\Jadwal;
use Illuminate\Support\Facades\Log;
use App\Models\Notification;
use App\Models\Article;

// Uncomment when models exist
// use App\Models\Schedule;
// use App\Models\Article;

class HomepageController extends Controller
{
    /**
     * Display the NilaHealth homepage.
     */
    public function index()
    {
        $user = Auth::user();
        $jadwals = Jadwal::where('users_id', $user->id)
                        ->orderBy('tanggal', 'asc')
                        ->orderBy('waktu', 'asc')
                        ->get();

        // Tambahkan query untuk artikel
        $latestArticles = Article::with('author')
                                ->latest()
                                ->take(3)
                                ->get();

        return view('frontend.pages.homepage.homepage', compact('jadwals', 'latestArticles'));
    }
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'tanggal' => 'required|date',
                'waktu' => 'required',
                'keterangan' => 'required',
                'recurrence_type' => 'required|in:once,daily,custom',
                'recurrence_days' => 'required_if:recurrence_type,custom|array',
                'remind_before' => 'required|integer|min:0'
            ]);

            $data['users_id'] = Auth::id();
            $jadwal = Jadwal::create($data);

            return response()->json([
                'message' => 'Jadwal berhasil disimpan',
                'data' => $jadwal
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Tampilkan satu jadwal (untuk fill modal Edit).
     */
    public function show(Jadwal $jadwal)
    {
        if ($jadwal->users_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        return response()->json($jadwal);
    }

    /**
     * Update jadwal via AJAX.
     */
    public function update(Request $request, Jadwal $jadwal)
    {
        if ($jadwal->users_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        try {
            $data = $request->validate([
                'tanggal' => 'required|date',
                'waktu' => 'required',
                'keterangan' => 'required',
                'recurrence_type' => 'required|in:once,daily,custom',
                'recurrence_days' => 'required_if:recurrence_type,custom|array',
                'remind_before' => 'required|integer|min:0'
            ]);

            $jadwal->update($data);

            return response()->json([
                'message' => 'Jadwal berhasil diupdate',
                'data' => $jadwal
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Hapus jadwal via AJAX.
     */
    public function destroy(Jadwal $jadwal)
    {
        if ($jadwal->users_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        try {
            $jadwal->delete();
            return response()->json(['message' => 'Jadwal berhasil dihapus']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}