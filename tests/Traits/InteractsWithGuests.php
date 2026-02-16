<?php

namespace Quepenny\Livewire\Tests\Traits;

use App\Models\Guest;
use App\Models\User;
use Illuminate\Support\Facades\Session;

trait InteractsWithGuests
{
    public function actingAsGuestUser(?Guest $guest = null): static
    {
        Session::put('guest', $guest ?? Guest::query()->create());

        return $this;
    }

    public function actingAsMemberUser(?User $user = null): static
    {
        $this->actingAs($user ?: User::factory()->create());

        return $this;
    }
}
