<?php

namespace Quepenny\Livewire\Providers;

use Illuminate\Auth\Events\Login;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Quepenny\Livewire\Listeners\TransferGuestDataOnLogin;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Login::class => [
            TransferGuestDataOnLogin::class,
        ],
    ];
}
