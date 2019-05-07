<?php

namespace Tests\WebPortal\Features;

use Behat\Behat\Context\Context;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\Behat\Event\FeatureEvent;
use EddIriarte\WebPortal\Gateway\ConsumerClient;
use GuzzleHttp\Client;
use PhpPact\Consumer\InteractionBuilder;
use PhpPact\Standalone\MockService\MockServer;
use PhpPact\Standalone\MockService\MockServerConfig;
use PhpPact\Consumer\Model\ConsumerRequest;
use PhpPact\Standalone\MockService\Service\MockServerHttpService;
use PhpPact\Http\GuzzleClient;
use PhpPact\Broker\Service\BrokerHttpClient;
use EddIriarte\WebPortal\Domain\Credentials;
use GuzzleHttp\Psr7\Uri;
use PhpPact\Consumer\Matcher\Matcher;
use PhpPact\Consumer\Model\ProviderResponse;

/**
 * Defines application features from the specific context.
 */
class ConsumerContractContext implements Context
{
    /**
     * @var MockServerConfig
     */
    public static $consumerMockConfig;

    /**
     * @var MockServer
     */
    public static $consumerMockServer;

    /**
     * @var string
     */
    public static $given;

    /**
     * @var Credentials
     */
    private $credentials;

    /**
     * @var ConsumerRequest
     */
    private $request;

    /**
     * @var ProviderResponse
     */
    private $response;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
    }

    /** @BeforeFeature @contract */
    public static function setupFeature($event)
    {
        $port = rand(49152, 65535);
        
        self::$consumerMockConfig = (new MockServerConfig())
            ->setHost('localhost')
            ->setPactDir('localhost')
            ->setPort($port)
            ->setConsumer('web-portal')
            ->setLog('debug')
            ->setProvider('consumer-service')
            ->setHealthCheckTimeout(50);

        // Instantiate the mock server object with the config. This can be any
        // instance of MockServerConfigInterface.
        self::$consumerMockServer = new MockServer(self::$consumerMockConfig);

        // Create the process.
        self::$consumerMockServer->start();
    }

    /**
     * @BeforeScenario
     */
    public static function setupScenario(BeforeScenarioScope $event)
    {
        self::$given = $event->getScenario()->getTitle();
    }

    /** @AfterScenario */
    public static function teardownScenario($event)
    {

    }

    /** @AfterFeature @contract */
    public static function teardownFeature($event)
    {
        $json = null;

        try {
            $httpService = new MockServerHttpService(
                new GuzzleClient(),
                self::$consumerMockConfig
            );

            $httpService->verifyInteractions();

            $json = $httpService->getPactJson();
        } finally {
            // Stop the process.
            self::$consumerMockServer->stop();
        }

        self::publishPactContract($json);
    }

    public static function publishPactContract($json)
    {
        $clientConfig = [];

        if (($sslVerify = \getenv('PACT_BROKER_SSL_VERIFY'))) {
            $clientConfig['verify'] = $sslVerify !== 'no';
        }

        $client = new GuzzleClient($clientConfig);

        $brokerUrl = 'http://pact-broker.local'; // getenv('PACT_BROKER_URI');
        $consumerVersion = '1.0.0'; // getenv('PACT_CONSUMER_VERSION');
        $consumerTag = 'demo'; // getenv('PACT_CONSUMER_TAG');

        $brokerHttpService = new BrokerHttpClient($client, new Uri($brokerUrl));
        $brokerHttpService->publishJson($json, $consumerVersion);
        $brokerHttpService->tag(
            self::$consumerMockConfig->getConsumer(),
            $consumerVersion,
            $consumerTag
        );

        print 'Pact file has been uploaded to the Broker successfully.';
    }

    /**
     * @When /^I login with "([^"]+)" and "([^"]+)"$/
     */
    public function iLoginWithAnd($email, $password)
    {
        $this->credentials = new Credentials($email, $password);
    }

    /**
     * @Then my credentials are validated by consumer-service
     */
    public function myCredentialsAreValidatedByConsumerService()
    {
        $this->request = new ConsumerRequest();
        $this->request
            ->setMethod('POST')
            ->setPath('/consumers/verify')
            ->setBody([
                'email' => $this->credentials->getEmail(),
                'password' => $this->credentials->getPassword(),
            ])
            ->addHeader('Content-Type', 'application/json');
    }

    /**
     * @Then the response status code is :statusCode
     */
    public function theResponseStatusCodeIs($statusCode)
    {
        $this->response = new ProviderResponse();
        $this->response
            ->setStatus($statusCode)
            ->addHeader('Content-Type', 'application/json');
    }

    /**
     * @Then the response content contains error :message
     */
    public function theResponseContentContainsError($message)
    {
        $matcher = new Matcher();

        $this->response
            ->setBody([
                'error' => $matcher->like($message)
            ]);

        $this->makeInteraction('test', 'test123');
    }

    /**
     * @Then the response content contains consumer details
     */
    public function theResponseContentContainsConsumerDetails()
    {
        $matcher = new Matcher();

        $this->response
            ->setBody([
                'consumer_id' => $matcher->like('qwer123456'),
                'first_name' => $matcher->like('Bob'),
            ]);

        $this->makeInteraction('foo', 'bar baz');
    }

    public function makeInteraction($given, $uponReceiving)
    {
        // Create a configuration that reflects the server that was started. You can create a custom MockServerConfigInterface if needed.
        $builder = new InteractionBuilder(self::$consumerMockConfig);
        $builder
            ->given(self::$given)
            ->uponReceiving($uponReceiving)
            ->with($this->request)
            ->willRespondWith($this->response); // This has to be last. This is what makes an API request to the Mock Server to set the interaction.

        $result = (new ConsumerClient(new Client, (string)self::$consumerMockConfig->getBaseUri()))
            ->verifyConsumerCredentials(
                $this->credentials->getEmail(),
                $this->credentials->getPassword()
            );

        $builder->verify(); // This will verify that the interactions took place.
    }
}
