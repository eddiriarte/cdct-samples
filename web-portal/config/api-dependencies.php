<?php

return [
    'order_api' => [
        'base_url' => env('ORDER_API_BASE_URL', 'http://order')
    ],

    'auth_api' => [
        'base_url' => env('AUTH_API_BASE_URL', 'http://customer')
    ],
];
