<?php
namespace App\Listeners;

use Illuminate\Auth\Events\Authenticated;
use Illuminate\Support\Facades\Session;

class RedirectBasedOnRole
{
    public function handle(Authenticated $event): void
    {
        $user = $event->user;

        if ($user->role === 'admin') {
            Session::put('url.intended', route('admin.dashboard'));
        } else {
            Session::put('url.intended', route('home'));
        }
    }
}