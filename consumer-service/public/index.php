<?php

call_user_func(function () {
    if (PHP_SAPI == 'cli-server') {
        // To help the built-in PHP dev server, check if the request was actually for
        // something which should probably be served as a static file
        $url  = parse_url($_SERVER['REQUEST_URI']);
        $file = __DIR__ . $url['path'];
        if (is_file($file)) {
            return false;
        }
    }

    require dirname(__DIR__) . '/vendor/autoload.php';

    session_start();
    
    // Instantiate the app
    $config = require dirname(__DIR__) . '/config/settings.php';
    $app = new \Slim\App($config);
    
    // Set up container
    $container = require dirname(__DIR__) . '/config/container.php';
    $container($app);

    // Register middleware
    $middleware = require dirname(__DIR__) . '/config/middleware.php';
    $middleware($app);
    
    // Register routes
    $routes = require dirname(__DIR__) . '/config/routes.php';
    $routes($app);
    
    // Run app
    $app->run();
});
