<?php


namespace Tests\OrderApi;


use App\Services\Clients\CustomerApiClient;
use App\Services\Clients\OrderApiClient;
use PhpPact\Consumer\InteractionBuilder;
use PhpPact\Consumer\Matcher\Matcher;
use PhpPact\Consumer\Model\ConsumerRequest;
use PhpPact\Consumer\Model\ProviderResponse;
use PhpPact\Standalone\MockService\MockServerEnvConfig;
use Tests\TestCase;

class OrderApiConsumerTest extends TestCase
{
    /**
     * @test
     */
    public function it_creates_contract_for_order_api_provider()
    {
        // Create a configuration that reflects the server that was started. You can create a custom MockServerConfigInterface if needed.
        $mockServerConfig  = new MockServerEnvConfig();

        $builder = new InteractionBuilder($mockServerConfig);
        $builder
            ->uponReceiving('An order-summary requests to /customer/{customer_id}/orders')
            ->with($this->getPreparedOrderSummaryRequest())
            ->willRespondWith($this->getPreparedOrderSummaryResponse()); // This has to be last. This is what makes an API request to the Mock Server to set the interaction.

        $apiClient = new OrderApiClient($mockServerConfig->getBaseUri()); // Pass in the URL to the Mock Server.

        $result  = $apiClient->getOrdersByUserId("1"); // Make the real API request against the Mock Server.

        $builder->verify(); // This will verify that the interactions took place.

        self::assertCount(1, $result); // Make your assertions.
    }

    private function getPreparedOrderSummaryRequest(): ConsumerRequest
    {
        // Create your expected request from the consumer.
        $request = new ConsumerRequest();
        $request
            ->setMethod('GET')
            ->setPath('/api/v1/customers/1/orders')
            ->addHeader('Content-Type', 'application/json');

        return $request;
    }

    private function getPreparedOrderSummaryResponse(): ProviderResponse
    {
        $matcher = new Matcher();

        // Create your expected response from the provider.
        $response = new ProviderResponse();
        $response
            ->setStatus(200)
            ->addHeader('Content-Type', 'application/json')
            ->setBody(
                $matcher->eachLike([
                    'id' => $matcher->uuid(),
                    'customer_id' => $matcher->integer(),
                    'ordered_at' => $matcher->dateTimeISO8601(),
                    'address' => $matcher->like('48616 Keven Bypass\nSouth Citlalli, OK 52951'),
                    'gross_total' => $matcher->decimal(),
                    'tax_rate' => $matcher->decimal(),
                    'currency' => $matcher->like('EUR'),
                ])
            );

        return $response;
    }
}
