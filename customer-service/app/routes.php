<?php
declare(strict_types=1);

use App\Application\Actions\Auth\LoginAction;
use App\Application\Actions\Customer\ListCustomersAction;
use App\Application\Actions\Customer\ViewCustomerAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    $app->get('/', function (Request $request, Response $response) {
        $response->getBody()->write('Hello world!');
        return $response;
    });

    $app->group('/api/v1', function (Group $group) {

        $group->post('/auth', LoginAction::class);

        $group->get('/customers', ListCustomersAction::class);
        $group->get('/customers/{id}', ViewCustomerAction::class);
    });

};
