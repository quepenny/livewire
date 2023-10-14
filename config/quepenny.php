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
    | Handles a guest-member finally signing-in and becoming a full-member.
    | Can use this listener to transfer all their data to the new account.
    */

    'guest_member_login_listener' => null,
];
