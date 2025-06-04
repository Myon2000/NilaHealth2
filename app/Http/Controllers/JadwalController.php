<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class JadwalController extends Controller
{
    /**
     * Tampilkan daftar jadwal milik user.
     */
    public function index()
    {
        $jadwals = Jadwal::where('users_id', Auth::id())
                         ->orderBy('tanggal', 'asc')
                         ->orderBy('waktu', 'asc')
                         ->get();

        return view('frontend.pages.jadwal.index', compact('jadwals'));
    }

    /**
     * Simpan jadwal baru via AJAX.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'tanggal'          => 'required|date',
                'waktu'            => 'required|date_format:H:i',
                'keterangan'       => 'required|string|max:255',
                'recurrence_type'  => 'required|in:once,daily,custom',
                'recurrence_days'  => 'nullable|array',
                'recurrence_days.*'=> 'in:mon,tue,wed,thu,fri,sat,sun',
                'remind_before'    => 'required|integer|min:0',
            ]);

            $jadwal = Jadwal::create([
                'users_id'        => Auth::id(),
                'tanggal'         => $validated['tanggal'],
                'waktu'           => $validated['waktu'],
                'keterangan'      => $validated['keterangan'],
                'recurrence_type' => $validated['recurrence_type'],
                'recurrence_days' => $validated['recurrence_type'] === 'custom'
                                     ? $validated['recurrence_days']
                                     : null,
                'remind_before'   => $validated['remind_before'],
            ]);

            app(NotificationController::class)->sendJadwalNotification($jadwal);

            return response()->json([
                'success' => true,
                'message' => 'Jadwal berhasil ditambahkan dan notifikasi dikirim!',
                'data'    => $jadwal,
            ]);
        } catch (\Throwable $e) {
            Log::error('Jadwal store error: '.$e->getMessage(), ['exception'=>$e]);
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan jadwal: '.$e->getMessage(),
            ], 500);
        }
    }

    /**
     * Tampilkan satu jadwal (untuk fill modal Edit).
     */
    public function show(Jadwal $jadwal)
    {
        if ($jadwal->users_id !== Auth::id()) {
            return response()->json(['message'=>'Unauthorized'], 403);
        }

        return response()->json([
            'id'              => $jadwal->id,
            'tanggal'         => $jadwal->tanggal->format('Y-m-d'),
            'waktu'           => $jadwal->waktu->format('H:i'),
            'keterangan'      => $jadwal->keterangan,
            'recurrence_type' => $jadwal->recurrence_type,
            'recurrence_days' => $jadwal->recurrence_days ?? [],
            'remind_before'   => $jadwal->remind_before,
        ]);
    }

    /**
     * Update jadwal via AJAX.
     */
    public function update(Request $request, Jadwal $jadwal)
    {
        if ($jadwal->users_id !== Auth::id()) {
            return response()->json(['message'=>'Unauthorized'], 403);
        }

        try {
            $validated = $request->validate([
                'tanggal'          => 'required|date',
                'waktu'            => 'required|date_format:H:i',
                'keterangan'       => 'required|string|max:255',
                'recurrence_type'  => 'required|in:once,daily,custom',
                'recurrence_days'  => 'nullable|array',
                'recurrence_days.*'=> 'in:mon,tue,wed,thu,fri,sat,sun',
                'remind_before'    => 'required|integer|min:0',
            ]);

            $jadwal->update([
                'tanggal'         => $validated['tanggal'],
                'waktu'           => $validated['waktu'],
                'keterangan'      => $validated['keterangan'],
                'recurrence_type' => $validated['recurrence_type'],
                'recurrence_days' => $validated['recurrence_type'] === 'custom'
                                     ? $validated['recurrence_days']
                                     : null,
                'remind_before'   => $validated['remind_before'],
            ]);

            Notification::create([
                'user_id'      => Auth::id(),
                'jadwal_id'    => $jadwal->id,
                'message'      => "Jadwal diperbarui: {$jadwal->keterangan} pada {$jadwal->tanggal->format('d M Y')}",
                'scheduled_at' => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Jadwal berhasil diperbarui!',
                'data'    => $jadwal,
            ]);
        } catch (\Throwable $e) {
            Log::error('Jadwal update error: '.$e->getMessage(), ['exception'=>$e]);
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui: '.$e->getMessage(),
            ], 500);
        }
    }

    /**
     * Hapus jadwal via AJAX.
     */
    public function destroy(Jadwal $jadwal)
    {
        if ($jadwal->users_id !== Auth::id()) {
            return response()->json(['message'=>'Unauthorized'], 403);
        }

        try {
            $jadwal->delete();
            return response()->json([
                'success' => true,
                'message' => 'Jadwal berhasil dihapus!',
            ]);
        } catch (\Throwable $e) {
            Log::error('Jadwal delete error: '.$e->getMessage(), ['exception'=>$e]);
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus: '.$e->getMessage(),
            ], 500);
        }
    }
}
