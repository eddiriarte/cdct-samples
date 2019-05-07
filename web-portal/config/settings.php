<?php

return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header

        // Renderer settings
        'renderer' => [
            'template_path' => dirname(__DIR__) . '/templates',
            'cache_path' => dirname(__DIR__) . '/var/cache/views',
        ],

    ],
];
