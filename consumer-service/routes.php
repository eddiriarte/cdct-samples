<?php

use Slim\App;
use EddIriarte\Consumer\Action\GetApplicationVersion;

return function (App $app) {
    
    $app->get('/', \EddIriarte\Consumer\Action\GetApplicationVersion::class);
    $app->get('/version', \EddIriarte\Consumer\Action\GetApplicationVersion::class);
    
};
