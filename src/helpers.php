<?php

use Quepenny\Livewire\Models\Guest;
use Quepenny\Livewire\Models\User;

if (!function_exists('user')) {
    function user(): User|Guest|null
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
