<?php

namespace Quepenny\Livewire\Tests\Feature\Auth;

use App\Models\Guest;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Support\Facades\Cookie;
use Quepenny\Livewire\Http\Middleware\GuestToken;

class GuestTokenTest extends TestCase
{
    use DatabaseTransactions;

    public function test_guest_token_created_for_guest(): void
    {
        config('quepenny.guest_members') || $this->markTestSkipped();

        $this
            ->get('/')
            ->assertCookie(config('quepenny.guest_token_name'));
    }

    public function test_guest_token_not_created_for_member(): void
    {
        config('quepenny.guest_members') || $this->markTestSkipped();

        $this
            ->actingAs(User::factory()->create())
            ->get('/')
            ->assertCookieMissing(config('quepenny.guest_token_name'));
    }

    public function test_guest_account_retrieved_from_token(): void
    {
        config('quepenny.guest_members') || $this->markTestSkipped();

        $token = 'test-token';
        $guest = Guest::query()->create(compact('token'));

        $this
            ->withCookie(config('quepenny.guest_token_name'), $token)
            ->get('/')
            ->assertSessionHas('guest.id', $guest->id);
    }

    public function test_guest_token_is_immutable_locally(): void
    {
        config('quepenny.guest_members') || $this->markTestSkipped();

        // Check the default guest token is set for non-production environments.
        $this
            ->get('/')
            ->assertCookie(
                config('quepenny.guest_token_name'),
                config('quepenny.guest_token_default'),
            );

        // Unset the token and check if it is set again.
        $this
            ->withCookie(config('quepenny.guest_token_name'), '')
            ->get('/')
            ->assertCookie(
                config('quepenny.guest_token_name'),
                config('quepenny.guest_token_default'),
            );
    }

    public function test_guest_token_is_mutable_on_production(): void
    {
        config('quepenny.guest_members') || $this->markTestSkipped();

        // Set the environment to production.
        config(['app.env' => 'production']);

        // Initially set the default guest token for production.
        $this
            ->withCookie(
                config('quepenny.guest_token_name'),
                config('quepenny.guest_token_default'),
            )
            ->get('/')
            ->assertCookie(
                config('quepenny.guest_token_name'),
                config('quepenny.guest_token_default'),
            );

        // Unset the token and check if it's reset to a new value.
        $guestTokenCookie = $this
            ->withCookie(config('quepenny.guest_token_name'), '')
            ->get('/')
            ->getCookie(config('quepenny.guest_token_name'));

        $this->assertNotNull($guestTokenCookie->getValue() ?: null);

        $this->assertNotEquals(
            $guestTokenCookie->getValue(),
            config('quepenny.guest_token_default')
        );
    }
}
