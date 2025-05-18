<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use App\Models\Jadwal;

// Uncomment when models exist
// use App\Models\Schedule;
// use App\Models\Article;

class HomepageController extends Controller
{
    /**
     * Display the NilaHealth homepage.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // Fetch jadwal for logged in user
        $schedules = Jadwal::where('users_id', $user->id)
                        ->orderBy('tanggal', 'asc')
                        ->orderBy('waktu', 'asc')
                        ->take(5) // Limit 5 jadwal terbaru
                        ->get();

        return view('frontend.pages.homepage.homepage', [
            'user' => $user,
            'schedules' => $schedules
        ]);
    }
}
