<?php

return [

    /*
    |---------------------------------------------------------------------------
    | Guest-Members
    |---------------------------------------------------------------------------
    |
    | Guests can have access to core features and own assets without signing in.
    |
    */

    'guest_members' => true,

    /*
    |---------------------------------------------------------------------------
    | Guest-Member Login Listener
    |---------------------------------------------------------------------------
    |
    | Handles a guest-member finally signing in and becoming a full-member.
    | Can use this listener to transfer all their data to the new account.
    */

    'guest_member_login_listener' => null,

    /*
    |---------------------------------------------------------------------------
    | Guest Token Name
    |---------------------------------------------------------------------------
    |
    | The name of the cookie that stores the guest token.
    */

    'guest_token_name' => strtolower(config('app.name')) . '-guest-token',

    /*
    |---------------------------------------------------------------------------
    | Guest Token Default
    |---------------------------------------------------------------------------
    |
    | For development purposes, we can set a default guest token to avoid
    | creating a new guest record on every request.
    */

    'guest_token_default' => env('GUEST_TOKEN_DEFAULT', '01jczhzrhxv3ag8fph2mzcsy4p'),

    /*
    |--------------------------------------------------------------------------
    | Button Variants
    |--------------------------------------------------------------------------
    |
    | Here you may define all the button variants available to your
    | application. These variants are used by the Button component to
    | determine the CSS classes for various states of the button.
    |
    */

    'button_variants' => [
        'black-outline' => [
            'hoverBackground' => 'bg-black',
            'border' => 'border-black',
            'text' => 'text-black',
            'hoverText' => 'hover:text-white',
            'focusRing' => 'focus:ring-black',
            'disabledBackground' => 'disabled:bg-gray-200',
            'disabledBorder' => 'disabled:border-gray-200',
            'disabledText' => 'disabled:text-gray-400',
        ],
        'teal-outline' => [
            'hoverBackground' => 'bg-teal-600',
            'border' => 'border-teal-600',
            'text' => 'text-teal-600',
            'hoverText' => 'hover:text-white',
            'focusRing' => 'focus:ring-teal-600',
            'disabledBackground' => 'disabled:bg-transparent',
            'disabledBorder' => 'disabled:border-gray-200',
            'disabledText' => 'disabled:text-gray-400',
        ],
        'teal' => [
            'background' => 'bg-teal-600',
            'hoverBackground' => 'bg-gray-100',
            'border' => 'border-teal-600',
            'text' => 'text-white',
            'hoverText' => 'hover:text-teal-600',
            'focusRing' => 'focus:ring-teal-600',
            'disabledBackground' => 'disabled:bg-teal-200',
            'disabledBorder' => 'disabled:border-teal-200',
            'disabledText' => 'disabled:text-white',
        ],
        'black' => [
            'background' => 'bg-black',
            'hoverBackground' => 'bg-transparent',
            'border' => 'border-black',
            'text' => 'text-white',
            'hoverText' => 'hover:text-black',
            'focusRing' => 'focus:ring-black',
            'disabledBackground' => 'disabled:bg-gray-400',
            'disabledBorder' => 'disabled:border-gray-400',
            'disabledText' => 'disabled:text-white',
        ],
        'gray-outline' => [
            'hoverBackground' => 'bg-gray-400',
            'border' => 'border-gray-400',
            'text' => 'text-gray-400',
            'hoverText' => 'hover:text-white',
            'focusRing' => 'focus:ring-gray-400',
            'disabledBackground' => 'disabled:bg-transparent',
            'disabledBorder' => 'disabled:border-gray-100',
            'disabledText' => 'disabled:text-gray-200',
        ],
        'gray' => [
            'background' => 'bg-gray-400',
            'hoverBackground' => 'bg-gray-100',
            'border' => 'border-gray-400',
            'text' => 'text-white',
            'hoverText' => 'hover:text-gray-400',
            'focusRing' => 'focus:ring-gray-400',
            'disabledBackground' => 'disabled:bg-gray-200',
            'disabledBorder' => 'disabled:border-gray-200',
            'disabledText' => 'disabled:text-white',
        ],
        'white-outline' => [
            'hoverBackground' => 'bg-white',
            'border' => 'border-white',
            'text' => 'text-white',
            'hoverText' => 'hover:text-black',
            'focusRing' => 'focus:ring-white',
            'disabledBackground' => 'disabled:bg-transparent',
            'disabledBorder' => 'disabled:border-gray-600',
            'disabledText' => 'disabled:text-gray-600',
        ],
        'red-outline' => [
            'hoverBackground' => 'bg-red-500',
            'border' => 'border-red-500',
            'text' => 'text-red-500',
            'hoverText' => 'hover:text-white',
            'focusRing' => 'focus:ring-red-500',
            'disabledBackground' => 'disabled:bg-red-200',
            'disabledBorder' => 'disabled:border-red-200',
            'disabledText' => 'disabled:text-white',
        ],
        'red-600-outline' => [
            'hoverBackground' => 'bg-red-600',
            'border' => 'border-red-600',
            'text' => 'text-red-600',
            'hoverText' => 'hover:text-white',
            'focusRing' => 'focus:ring-red-600',
            'disabledBackground' => 'disabled:bg-red-200',
            'disabledBorder' => 'disabled:border-red-200',
            'disabledText' => 'disabled:text-white',
        ],
        'red' => [
            'background' => 'bg-red-500',
            'hoverBackground' => 'bg-gray-100',
            'border' => 'border-red-500',
            'text' => 'text-white',
            'hoverText' => 'hover:text-red-500',
            'focusRing' => 'focus:ring-red-500',
            'disabledBackground' => 'disabled:bg-red-200',
            'disabledBorder' => 'disabled:border-red-200',
            'disabledText' => 'disabled:text-white',
        ],
        'red-600' => [
            'background' => 'bg-red-600',
            'hoverBackground' => 'bg-gray-100',
            'border' => 'border-red-600',
            'text' => 'text-white',
            'hoverText' => 'hover:text-red-600',
            'focusRing' => 'focus:ring-red-600',
            'disabledBackground' => 'disabled:bg-red-200',
            'disabledBorder' => 'disabled:border-red-200',
            'disabledText' => 'disabled:text-white',
        ],
        'blue-outline' => [
            'hoverBackground' => 'bg-blue-600',
            'border' => 'border-blue-600',
            'text' => 'text-blue-600',
            'hoverText' => 'hover:text-white',
            'focusRing' => 'focus:ring-blue-600',
            'disabledBackground' => 'disabled:bg-transparent',
            'disabledBorder' => 'disabled:border-blue-200',
            'disabledText' => 'disabled:text-blue-200',
        ],
        'blue' => [
            'background' => 'bg-blue-600',
            'hoverBackground' => 'bg-gray-100',
            'border' => 'border-blue-600',
            'text' => 'text-white',
            'hoverText' => 'hover:text-blue-600',
            'focusRing' => 'focus:ring-blue-600',
            'disabledBackground' => 'disabled:bg-blue-200',
            'disabledBorder' => 'disabled:border-blue-200',
            'disabledText' => 'disabled:text-white',
        ],
    ],
];
