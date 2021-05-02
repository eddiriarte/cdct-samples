<?php
declare(strict_types=1);

namespace Tests\Application\Actions\Customer;

use App\Application\Actions\ActionError;
use App\Application\Actions\ActionPayload;
use App\Application\Handlers\HttpErrorHandler;
use App\Domain\Customer\Customer;
use App\Domain\Customer\CustomerNotFoundException;
use App\Domain\Customer\CustomerRepository;
use DI\Container;
use Prophecy\PhpUnit\ProphecyTrait;
use Slim\Middleware\ErrorMiddleware;
use Tests\TestCase;

class ViewCustomerActionTest extends TestCase
{
    use ProphecyTrait;

    public function testAction()
    {
        $app = $this->getAppInstance();

        /** @var Container $container */
        $container = $app->getContainer();

        $user = new Customer(1, 'obi-wan.kenobi@jedi.org', 'Obi-Wan', 'Kenobi');

        $userRepositoryProphecy = $this->prophesize(CustomerRepository::class);
        $userRepositoryProphecy
            ->findCustomerById(1)
            ->willReturn($user)
            ->shouldBeCalledOnce();

        $container->set(CustomerRepository::class, $userRepositoryProphecy->reveal());

        $request = $this->createRequest('GET', '/api/v1/customers/1');
        $response = $app->handle($request);

        $payload = (string) $response->getBody();
        $expectedPayload = new ActionPayload(200, $user);
        $serializedPayload = json_encode($expectedPayload, JSON_PRETTY_PRINT);

        $this->assertEquals($serializedPayload, $payload);
    }

    public function testActionThrowsUserNotFoundException()
    {
        $app = $this->getAppInstance();

        $callableResolver = $app->getCallableResolver();
        $responseFactory = $app->getResponseFactory();

        $errorHandler = new HttpErrorHandler($callableResolver, $responseFactory);
        $errorMiddleware = new ErrorMiddleware($callableResolver, $responseFactory, true, false ,false);
        $errorMiddleware->setDefaultErrorHandler($errorHandler);

        $app->add($errorMiddleware);

        /** @var Container $container */
        $container = $app->getContainer();

        $userRepositoryProphecy = $this->prophesize(CustomerRepository::class);
        $userRepositoryProphecy
            ->findCustomerById(1)
            ->willThrow(new CustomerNotFoundException())
            ->shouldBeCalledOnce();

        $container->set(CustomerRepository::class, $userRepositoryProphecy->reveal());

        $request = $this->createRequest('GET', '/api/v1/customers/1');
        $response = $app->handle($request);

        $payload = (string) $response->getBody();
        $expectedError = new ActionError(ActionError::RESOURCE_NOT_FOUND, 'The user you requested does not exist.');
        $expectedPayload = new ActionPayload(404, null, $expectedError);
        $serializedPayload = json_encode($expectedPayload, JSON_PRETTY_PRINT);

        $this->assertEquals($serializedPayload, $payload);
    }
}
