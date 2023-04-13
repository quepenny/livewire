<?php

namespace Quepenny\Livewire\Http\Middleware;

use Quepenny\Livewire\Models\Guest;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class GuestToken
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::guest()) {
            $token = $request->cookie('shopally-guest-token');

            Session::put(
                'guest',
                $token ? Guest::firstOrCreate(['token' => $token]) : Guest::create()
            );
        }

        $response = $next($request);

        return Auth::guest() ? $response->withCookie(
            'shopally-guest-token',
            user()?->token ?? $request->cookie('shopally-guest-token')
        ) : $response;
    }
}
