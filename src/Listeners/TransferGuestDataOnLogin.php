<?php

namespace Quepenny\Livewire\Listeners;

use Illuminate\Auth\Events\Login;

class TransferGuestDataOnLogin
{
    public function handle(Login $event): void
    {
        if (
            config('quepenny.guest_members')
            && $listener = config('quepenny.guest_member_login_listener')
        ) {
            $listener->handle($event);
        }
    }
}
