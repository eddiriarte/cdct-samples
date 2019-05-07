<?php

use Slim\App;
use Pimple\Psr11\Container;

return function (App $app) {
    /** @var Container $container */
    $container = $app->getContainer();

    $container['version'] = function (): string {
        $json = json_decode(
            file_get_contents(__DIR__ . '/composer.json')
        );

        return $json->version;
    };

    // Register Twig View helper
    $container['view'] = function ($container) {
        $settings = $container->get('settings')['renderer'];

        $view = new \Slim\Views\Twig(
            $settings['template_path'], 
            [
                'cache' => false, // $settings['cache_path'],
            ]
        );
        
        // Instantiate and add Slim specific extension
        $router = $container->get('router');
        $uri = \Slim\Http\Uri::createFromEnvironment(new \Slim\Http\Environment($_SERVER));
        $view->addExtension(new \Slim\Views\TwigExtension($router, $uri));

        return $view;
    };
};
