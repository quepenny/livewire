<?php

namespace Quepenny\Livewire\Tests\Traits;

use App\Models\Guest;
use App\Models\User;
use Illuminate\Support\Facades\Session;

trait InteractsWithGuests
{
    protected function actingAsGuest(Guest $guest = null): static
    {
        Session::put('guest', $guest ?? Guest::query()->create());

        return $this;
    }

    protected function actingAsMember(User $user = null): static
    {
        $this->actingAs($user ?: User::factory()->create());

        return $this;
    }
}
