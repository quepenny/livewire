<?php

namespace Quepenny\Livewire\Providers;

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Quepenny\Livewire\Http\Middleware\GuestToken;

class RouteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        app(Kernel::class)->pushMiddleware(GuestToken::class);
        $this->loadRoutesFrom(__DIR__.'/../../routes/web.php');
    }
}
