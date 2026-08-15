<?php

namespace Quepenny\Livewire\Providers;

use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Quepenny\Livewire\Listeners\TransferGuestDataOnLogin;

class EventServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Event::listen(Login::class, TransferGuestDataOnLogin::class);
    }
}
