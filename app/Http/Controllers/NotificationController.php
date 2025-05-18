<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class NotificationController extends Controller
{
    /**
     * Display a listing of notifications for the user.
     */
    public function index()
    {
        try {
            // Assuming User model has notifications() relation
            $notifications = Auth::user()
                ->notifications()
                ->with(['jadwal:id,keterangan,waktu'])
                ->orderBy('created_at', 'desc')
                ->get();

            return view('frontend.pages.notifications.index', compact('notifications'));
        } catch (\Throwable $e) {
            Log::error('Notification index error: ' . $e->getMessage(), ['exception' => $e]);
            notify()->error('Gagal memuat notifikasi');
            return redirect()->back();
        }
    }

    /**
     * Mark a single notification as read via AJAX.
     */
    public function markAsRead($id)
    {
        try {
            $notification = Notification::findOrFail($id);

            if ($notification->user_id !== Auth::id()) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
            }

            $notification->update(['is_read' => true]);

            return response()->json(['success' => true, 'message' => 'Notifikasi ditandai sudah dibaca']);
        } catch (\Throwable $e) {
            Log::error('Notification markAsRead error: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json(['success' => false, 'message' => 'Gagal menandai notifikasi'], 500);
        }
    }

    /**
     * Mark all notifications as read via AJAX.
     */
    public function markAllAsRead()
    {
        try {
            Auth::user()
                ->notifications()
                ->update(['is_read' => true]);

            return response()->json(['success' => true, 'message' => 'Semua notifikasi ditandai sudah dibaca']);
        } catch (\Throwable $e) {
            Log::error('Notification markAllAsRead error: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json(['success' => false, 'message' => 'Gagal menandai semua notifikasi'], 500);
        }
    }
}
