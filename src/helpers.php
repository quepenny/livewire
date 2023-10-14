<?php

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;
use App\Models\Guest;

if (! function_exists('guest')) {
    /**
     * Return guest-member
     */
    function guest(): Guest|null
    {
        return session('guest');
    }
}

if (! function_exists('is_divisible')) {
    /**
     * Check if dividend is perfectly divisible by divisor
     */
    function is_divisible(float|int $dividend, float|int $divisor): bool
    {
        if (is_int($dividend) && is_int($divisor)) {
            return $dividend % $divisor === 0;
        }

        $division = $dividend / $divisor;
        // Confirm division is a whole number
        // Due to issues with float precision, direct comparison isn't ideal
        return round($division) == strval($division);
    }
}

if (! function_exists('once')) {
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

if (! function_exists('str_to_num')) {
    /**
     * Create number from numeric string
     * Returns zero if non-numeric
     */
    function str_to_num(string $value): float|int
    {
        if (is_numeric($value)) {
            return $value + 0;
        }

        return 0;
    }
}

if (! function_exists('titleplace')) {
    /**
     * Convert text to title-case after replacing 'search' with 'replace'
     */
    function titleplace(string $text, string $search = '-', string $replace = ' '): string
    {
        return ucwords(str_replace($search, $replace, $text));
    }
}

if (! function_exists('user')) {
    /**
     * Return authenticated user or guest-member
     */
    function user(): Authenticatable|Guest
    {
        return Auth::user() ?? guest();
    }
}
