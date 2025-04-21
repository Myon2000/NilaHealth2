<?php

namespace App\Listeners;

use App\Models\User;
use Illuminate\Auth\Events\Login as AuthLogin;

class UpdateLastLogin
{
    /**
     * Handle the event.
     */
    public function handle(AuthLogin $event): void
    {
        // Cast user ke App\Models\User sehingga IDE mengenali method save()
        if ($event->user instanceof User) {
            /** @var User $user */
            $user = $event->user;
            $user->last_login = now();
            $user->save();
        }
    }
}