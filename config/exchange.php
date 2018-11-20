<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cache
    |--------------------------------------------------------------------------
    |
    | This option specifies the Laravel cache store to use.
    |
    | 'cache' => 'file'
    */
    'cache' => false,

    'default' => [

        'driver' => env('EXCHANGE_DRIVER', 'FixerProvider')

    ],

    'drivers' => [

        'fixer' => [
            'provider' => 'FixerProvider',
            'api_key' => env('FIXER_API_KEY', null),
            'enterprise' => env('FIXER_ENTERPRISE', false)
        ]

    ]

];
