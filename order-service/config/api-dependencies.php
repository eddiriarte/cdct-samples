<?php

return [
    'payment_api' => [
        'base_url' => env('ORDER_API_BASE_URL', 'http://payment')
    ],

    'customer_api' => [
        'base_url' => env('AUTH_API_BASE_URL', 'http://customer')
    ],
];
