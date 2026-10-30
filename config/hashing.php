<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Hash Driver
    |--------------------------------------------------------------------------
    | Поддерживаются: bcrypt, argon, argon2id, habbo-md5, habbo-sha1
    | Ретро-отели обычно хранят пароль как md5 -> оставь habbo-md5.
    */

    'driver' => env('HASH_DRIVER', 'habbo-md5'),

    'bcrypt' => [
        'rounds' => env('BCRYPT_ROUNDS', 12),
        'verify' => env('HASH_VERIFY', true),
    ],

    'argon' => [
        'memory' => env('ARGON_MEMORY', 65536),
        'threads' => env('ARGON_THREADS', 1),
        'time' => env('ARGON_TIME', 4),
        'verify' => env('HASH_VERIFY', true),
    ],

];
