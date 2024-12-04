<?php

namespace Quepenny\Livewire\Http\Middleware;

use App\Models\Guest;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class GuestToken
{
    public function handle(Request $request, Closure $next)
    {
        if (! config('quepenny.guest_members')) {
            return $next($request);
        }

        if (Auth::guest()) {
            $token = $request->cookie(config('quepenny.guest_token_name'));

            if (! $token) {
                // For development purposes, set a default guest-token to
                // avoid creating a new guest record on every request.
                $token = config('app.env') === 'production'
                    ? null
                    : config('quepenny.guest_token_default');
            }

            Session::put(
                'guest',
                $token
                    ? Guest::query()->firstOrCreate(['token' => $token])
                    : Guest::query()->create()
            );
        }

        $response = $next($request);

        return Auth::guest()
            ? $response->withCookie(config('quepenny.guest_token_name'), guest()?->token)
            : $response;
    }
}
