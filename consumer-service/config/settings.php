<?php

define('APP_ROOT', dirname(__DIR__));

return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header
        'doctrine' => [
            // if true, metadata caching is forcefully disabled
            'dev_mode' => true,

            // path where the compiled metadata info will be cached
            // make sure the path exists and it is writable
            'cache_dir' => APP_ROOT . '/var/doctrine',

            // you should add any other path containing annotated entity classes
            'metadata_dirs' => [APP_ROOT . '/src/Domain'],

            'connection' => [
                'driver' => 'pdo_sqlite',
                'path' => APP_ROOT . '/var/database.sqlite',
                'charset' => 'utf-8',
            ],

            'dbal' => [
                'types' => [
                    'uuid' => \Ramsey\Uuid\Doctrine\UuidType::class
                ],
            ],
        ],
    ],
];
