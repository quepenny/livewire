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
];
