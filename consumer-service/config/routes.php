<?php

use Slim\App;
use EddIriarte\Consumer\Action\GetApplicationVersion;

return function (App $app) {
    $app->get('/', \EddIriarte\Consumer\Action\GetApplicationVersion::class);

    $app->get(
        '/consumers/{consumerId}/addresses/{addressId}',
        \EddIriarte\Consumer\Action\FindConsumerWithAddress::class
    );

    // Endpoint for Contract Tests
    $app->post(
        '/dev-pact/provider-state',
        \EddIriarte\Consumer\Action\SetAppStateForContractVerification::class
    );
};
