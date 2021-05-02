<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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

$router->get('/', fn () => view('auth.login'));
$router->post('/login', \App\Http\Controllers\LogIn::class);
$router->get('/orders', \App\Http\Controllers\OrderSummary::class);
$router->get('/orders/{order_id}', \App\Http\Controllers\OrderDetails::class);
