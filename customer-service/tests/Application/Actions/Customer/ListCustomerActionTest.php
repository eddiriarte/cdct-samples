<?php
declare(strict_types=1);

namespace Tests\Application\Actions\Customer;

use App\Application\Actions\ActionPayload;
use App\Domain\Customer\CustomerRepository;
use App\Domain\Customer\Customer;
use DI\Container;
use Prophecy\PhpUnit\ProphecyTrait;
use Tests\TestCase;

class ListCustomerActionTest extends TestCase
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
            ->findAll()
            ->willReturn([$user])
            ->shouldBeCalledOnce();

        $container->set(CustomerRepository::class, $userRepositoryProphecy->reveal());

        $request = $this->createRequest('GET', '/api/v1/customers');
        $response = $app->handle($request);

        $payload = (string) $response->getBody();
        $expectedPayload = new ActionPayload(200, [$user]);
        $serializedPayload = json_encode($expectedPayload, JSON_PRETTY_PRINT);

        $this->assertEquals($serializedPayload, $payload);
    }
}
