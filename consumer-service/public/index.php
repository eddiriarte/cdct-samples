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

    require __DIR__ . '/../vendor/autoload.php';

    session_start();
    
    // Instantiate the app
    $config = require __DIR__ . '/../config.php';
    $app = new \Slim\App($config);
    
    // Set up container
    $container = require __DIR__ . '/../container.php';
    $container($app);

    // Register middleware
    $middleware = require __DIR__ . '/../middleware.php';
    $middleware($app);
    
    // Register routes
    $routes = require __DIR__ . '/../routes.php';
    $routes($app);
    
    // Run app
    $app->run();
});
