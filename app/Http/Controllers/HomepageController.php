<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;

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

        // Fetch schedules created by the logged-in user (placeholder if Schedule model not implemented)
        $schedules = collect();
        // if (class_exists(\App\Models\Schedule::class)) {
        //     $schedules = Schedule::where('user_id', $user->id)->get();
        // }

        // Fetch latest articles for preview (placeholder if Article model not implemented)
        $articles = collect();
        // if (class_exists(\App\Models\Article::class)) {
        //     $articles = Article::latest()->take(3)->get();
        // }

        return view('frontend.pages.homepage.homepage', [
            'user'      => $user,
            'schedules' => $schedules,
            'articles'  => $articles,
        ]);
    }
}
