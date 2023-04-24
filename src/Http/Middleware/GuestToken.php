<?php

namespace Quepenny\Livewire\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Quepenny\Livewire\Models\AbstractGuest;

class GuestToken
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::guest()) {
            $token = $request->cookie('shopally-guest-token');

            Session::put(
                'guest',
                $token ? AbstractGuest::firstOrCreate(['token' => $token]) : AbstractGuest::create()
            );
        }

        $response = $next($request);

        return Auth::guest() ? $response->withCookie(
            'shopally-guest-token',
            user()?->token ?? $request->cookie('shopally-guest-token')
        ) : $response;
    }
}
