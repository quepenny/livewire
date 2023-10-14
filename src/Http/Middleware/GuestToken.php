<?php

namespace Quepenny\Livewire\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Guest;

class GuestToken
{
    public function handle(Request $request, Closure $next)
    {
        if (! config('quepenny.guest_members')) {
            return $next($request);
        }

        if (Auth::guest()) {
            $token = $request->cookie($this->tokenName());

            Session::put(
                'guest',
                $token ? Guest::firstOrCreate(['token' => $token]) : Guest::create()
            );
        }

        $response = $next($request);

        return Auth::guest() ? $response->withCookie(
            $this->tokenName(),
            user()?->token ?? $request->cookie($this->tokenName())
        ) : $response;
    }

    private function tokenName(): string
    {
        return strtolower(config('app.name')) . '-guest-token';
    }
}
