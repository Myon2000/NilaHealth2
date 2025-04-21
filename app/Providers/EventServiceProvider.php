<?php
namespace App\Providers;

use Illuminate\Auth\Events\Authenticated;
use App\Listeners\RedirectBasedOnRole;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Authenticated::class => [
            RedirectBasedOnRole::class,
        ],
    ];

    public function boot(): void
    {
        //
    }
}