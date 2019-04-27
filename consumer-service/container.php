<?php

use Slim\App;
use EddIriarte\Consumer\Action\GetApplicationVersion;

return function (App $app) {
    $container = $app->getContainer();

    $container['version'] = function ($c) {
        $json = json_decode(
            file_get_contents(__DIR__ . '/composer.json')
        );

        return $json->version;
    };

};