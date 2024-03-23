<?php

namespace Quepenny\Livewire\Providers;

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;
use Quepenny\Livewire\Http\Middleware\GuestToken;

class RouteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        app(Kernel::class)->appendMiddlewareToGroup('web', GuestToken::class);

        $this->routes(function () {
            Route::middleware('web')->group(__DIR__.'/../../routes/web.php');
        });
    }
}
