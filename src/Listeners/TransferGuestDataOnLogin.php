<?php

namespace Quepenny\Livewire\Listeners;

use Illuminate\Auth\Events\Login;

class TransferGuestDataOnLogin
{
    public function handle(Login $event): void
    {
    }
}
