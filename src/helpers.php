<?php

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;
use Quepenny\Livewire\Models\Guest;

if (!function_exists('user')) {
    function user(): Authenticatable|Guest
    {
        return Auth::user() ?? guest();
    }
}

if (!function_exists('guest')) {
    function guest(): Guest|null
    {
        return session('guest');
    }
}

if (!function_exists('once')) {
    /**
     * Assign a value to an instance/class variable ONCE via a callback
     * Subsequent calls will return that same value WITHOUT using the callback
     */
    function once(mixed &$var, callable $callback): mixed
    {
        if (filled($var)) {
            return $var;
        }

        return $var = $callback();
    }
}
