<?php

use Slim\App;

return function (App $app) {
    $app->get('/', function($request, $response) {
        return $this->view->render($response, 'welcome.html');
    });
};
