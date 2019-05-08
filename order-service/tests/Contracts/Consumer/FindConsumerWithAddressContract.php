<?php

namespace Test\Order\Contracts\Consumer;

use EddIriarte\Order\Gateway\ConsumerGateway;
use GuzzleHttp\Client;
use PhpPact\Consumer\InteractionBuilder;
use PhpPact\Consumer\Matcher\Matcher;
use PhpPact\Consumer\Model\ConsumerRequest;
use PhpPact\Consumer\Model\ProviderResponse;
use PHPUnit\Framework\TestCase;
use Tests\Order\Support\MockServerConfigFactory;

class FindConsumerWithAddressContract extends TestCase
{
    /**
     * @test
     * @throws \Exception
     */
    public function it_should_valid_consumer_and_address_data()
    {
        // Create your expected request from the consumer.
        $request = (new ConsumerRequest())
            ->setMethod('GET')
            ->addHeader('Content-Type', 'application/json')
            ->setPath('/consumers/0276313d-53f2-3831-91dd-b905400f137/addresses/cbd44fc9-97a6-3e43-ba60-3e2a5c459367');

        // Create your expected response from the provider.
        $response = (new ProviderResponse())
            ->setStatus(200)
            ->addHeader('Content-Type', 'application/json;charset=utf-8')
            ->setBody(
                $this->getVerifiableResponse(new Matcher())
            );

        $config = MockServerConfigFactory::get('consumer-service');

        // Create a configuration that reflects the server that was started. You can create a custom MockServerConfigInterface if needed.
        $builder = new InteractionBuilder($config);
        $builder
            ->given('existent consumer_id 0276313d-53f2-3831-91dd-b905400f6137 having address_id cbd44fc9-97a6-3e43-ba60-3e2a5c459367')
            ->uponReceiving('request for consumers with address')
            ->with($request)
            ->willRespondWith($response); // This has to be last. This is what makes an API request to the Mock Server to set the interaction.

        $result = (new ConsumerGateway(new Client(), (string)$config->getBaseUri()))
            ->findConsumerWithAddress(
                '0276313d-53f2-3831-91dd-b905400f137',
                'cbd44fc9-97a6-3e43-ba60-3e2a5c459367'
            );

        $builder->verify(); // This will verify that the interactions took place.

        $this->assertNotEmpty($result);
    }

    /**
     * @param Matcher $matcher
     * @return array
     * @throws \Exception
     */
    public function getVerifiableResponse(Matcher $matcher)
    {
        return [
            'id' => $matcher->uuid(),
            'first_name' => $matcher->like('Bob'),
            'last_name' => $matcher->like('Jones'),
            'email' => $matcher->like('waelchi@hotmail.com'),
            'address' => [
                'id' => $matcher->uuid(),
                'street' => $matcher->like('Baker Str. 221'),
                'city' => $matcher->like('London'),
                'postal_code' => $matcher->integer(12345),
                'state' => $matcher->like('London'),
                'country_code' => $matcher->like('GB'),
            ],
        ];
    }
}
