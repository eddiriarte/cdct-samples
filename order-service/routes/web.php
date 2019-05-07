<?php
use Laravel\Lumen\Routing\Router;
use EddIriarte\Order\Http\Controllers\SetProviderStateForPact;
use EddIriarte\Order\Http\Controllers\GetOrdersByConsumerId;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

return function (Router $router) {

    $router->get('/', function () {
        return response()->json('Order Service v1.0.0, powered by Lumen');
    });

    $router->get(
        '/orders/by-consumer/{consumer_id}',
        GetOrdersByConsumerId::class
    );

    $router->post(
        '/pact-dev/provider-state',
        SetProviderStateForPact::class
    );

};
