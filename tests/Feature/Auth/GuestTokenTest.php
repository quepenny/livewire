<?php

namespace Quepenny\Livewire\Tests\Feature\Auth;

use App\Models\Guest;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase;
use Quepenny\Livewire\Http\Middleware\GuestToken;

class GuestTokenTest extends TestCase
{
    use DatabaseTransactions;

    public function test_guest_token_created_for_guest(): void
    {
        config('quepenny.guest_members') || $this->markTestSkipped();

        $this
            ->get('/')
            ->assertCookie(GuestToken::tokenName());
    }

    public function test_guest_token_not_created_for_member(): void
    {
        config('quepenny.guest_members') || $this->markTestSkipped();

        $this
            ->actingAs(User::factory()->create())
            ->get('/')
            ->assertCookieMissing(GuestToken::tokenName());
    }

    public function test_guest_account_retrieved_from_token(): void
    {
        config('quepenny.guest_members') || $this->markTestSkipped();

        $token = 'test-token';
        $guest = Guest::query()->create(compact('token'));

        $this
            ->withCookie(GuestToken::tokenName(), $token)
            ->get('/')
            ->assertSessionHas('guest.id', $guest->id);
    }
}
