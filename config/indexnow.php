<?php

return [

    /*
    |--------------------------------------------------------------------------
    | IndexNow Configuration
    |--------------------------------------------------------------------------
    |
    | IndexNow allows search engines like Bing, Yandex, and others to quickly
    | index new and updated URLs from your website.
    |
    */

    'enabled' => env('INDEXNOW_ENABLED', true),

    'key' => env('INDEXNOW_KEY', '8f3c67d804d74cc989691be23221c1e4'),

    'host' => env('INDEXNOW_HOST', 'ashmacreations.net'),

    'key_location' => env('INDEXNOW_KEY_LOCATION', null),

    'endpoint' => env('INDEXNOW_ENDPOINT', 'https://api.indexnow.org/indexnow'),

    'endpoints' => [
        'https://api.indexnow.org/indexnow',
        'https://www.bing.com/indexnow',
        'https://yandex.com/indexnow',
    ],

];
