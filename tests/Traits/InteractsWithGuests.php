<?php

namespace Quepenny\Livewire\Tests\Traits;

use App\Models\Guest;
use Illuminate\Support\Facades\Session;

trait InteractsWithGuests
{
    protected function actingAsGuest(Guest $guest = null): static
    {
        Session::put('guest', $guest ?? Guest::query()->create());

        return $this;
    }
}
