<?php

return [

    /*
    |--------------------------------------------------------------------------
    | USER MODE
    |--------------------------------------------------------------------------
    |
    | Here you may specify the application's user mode. It will determine weather the application needs to know
    | which user is practicing or just go straight to the menu.
    |
    |
    | Supported Options: "single-user", "multi-users"
    |
    */

    'user_mode' => env('FLASHCARD_USER_MODE', 'single-user'),
];
