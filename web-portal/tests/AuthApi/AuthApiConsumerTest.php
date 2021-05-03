<?php

namespace Tests\AuthApi;

use App\Services\Clients\CustomerApiClient;
use GuzzleHttp\Psr7\Uri;
use PhpPact\Broker\Service\BrokerHttpClient;
use PhpPact\Consumer\InteractionBuilder;
use PhpPact\Consumer\Matcher\Matcher;
use PhpPact\Consumer\Model\ConsumerRequest;
use PhpPact\Consumer\Model\ProviderResponse;
use PhpPact\Http\GuzzleClient;
use PhpPact\Standalone\MockService\MockServer;
use PhpPact\Standalone\MockService\MockServerConfig;
use PhpPact\Standalone\MockService\Service\MockServerHttpService;
use Tests\TestCase;

class AuthApiConsumerTest extends TestCase
{
    private static MockServer $server;
    private static MockServerConfig $mockServerConfig;

    public static function setUpBeforeClass(): void
    {
        // Create your basic configuration. The host and port will need to match
        // whatever your Http Service will be using to access the providers data.
        $mockServerConfig = new MockServerConfig();
        $mockServerConfig->setHost('127.0.0.1');
        $mockServerConfig->setPort(random_int(4000, 5000));
        $mockServerConfig->setConsumer('Web-Portal');
        $mockServerConfig->setProvider('Customer Api');
        $mockServerConfig->setHealthCheckTimeout(60);
        $mockServerConfig->setHealthCheckRetrySec(1);
        $mockServerConfig->setPactFileWriteMode('overwrite');
        //$config->setCors(true);

        self::$mockServerConfig = $mockServerConfig;

        // Instantiate the mock server object with the config. This can be any
        // instance of MockServerConfigInterface.
        self::$server = new MockServer($mockServerConfig);

        self::$server->start();
    }

    public static function tearDownAfterClass(): void
    {
        try {
            self::publishContract();
        } finally {
            self::$server->stop();
        }
    }

    /**
     * @test
     */
    public function it_creates_contract_for_auth_api_provider()
    {
        $builder = new InteractionBuilder(self::$mockServerConfig);
        $builder
            ->uponReceiving('An authentication requests to /api/v1/auth')
            ->with($this->getPreparedInteractionRequest())
            ->willRespondWith($this->getPreparedInteractionResponse()); // This has to be last. This is what makes an API request to the Mock Server to set the interaction.

        $apiClient = new CustomerApiClient(self::$mockServerConfig->getBaseUri()); // Pass in the URL to the Mock Server.

        $result  = $apiClient->login('darth.vader@empire.gov'); // Make the real API request against the Mock Server.

        $builder->verify(); // This will verify that the interactions took place.

        self::assertEquals('darth.vader@empire.gov', $result->getUsername()); // Make your assertions.
    }

    private function getPreparedInteractionRequest(): ConsumerRequest
    {
        // Create your expected request from the consumer.
        $request = new ConsumerRequest();
        $request
            ->setMethod('POST')
            ->setPath('/api/v1/auth')
            ->setBody([
                'username' => 'darth.vader@empire.gov',
            ])
            ->addHeader('Content-Type', 'application/json');

        return $request;
    }

    private function getPreparedInteractionResponse(): ProviderResponse
    {
        $matcher = new Matcher();

        // Create your expected response from the provider.
        $response = new ProviderResponse();
        $response
            ->setStatus(200)
            ->addHeader('Content-Type', 'application/json')
            ->setBody([
                'data' => [
                    'id' => $matcher->integer(),
                    'username' => $matcher->like('darth.vader@empire.gov'),
                    'first_name' => $matcher->like('Darth'),
                    'last_name' => $matcher->like('Vader'),
                ]
            ]);

        return $response;
    }

    private static function publishContract()
    {
        $httpService = new MockServerHttpService(new GuzzleClient(), self::$mockServerConfig);
        $httpService->verifyInteractions();
        $json = $httpService->getPactJson();

        $brokerHttpService = new BrokerHttpClient(new GuzzleClient(), new Uri('http://pact-broker'));
        $brokerHttpService->tag(self::$mockServerConfig->getConsumer(), '1.0.0', 'demo');
        $brokerHttpService->publishJson($json, '1.0.0');
    }
}
