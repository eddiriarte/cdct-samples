<?php

namespace Tests\Order\Support;

use GuzzleHttp\Psr7\Uri;
use PhpPact\Broker\Service\BrokerHttpClient;
use PhpPact\Http\GuzzleClient;
use PhpPact\Standalone\MockService\MockServer;
use PhpPact\Standalone\MockService\Service\MockServerHttpService;
use PHPUnit\Framework\AssertionFailedError;
use PHPUnit\Framework\Test;
use PHPUnit\Framework\TestListener;
use PHPUnit\Framework\TestListenerDefaultImplementation;
use PHPUnit\Framework\TestSuite;

class CustomContractTestListener implements TestListener
{
    use TestListenerDefaultImplementation;

    /**
     * @var \Illuminate\Support\Collection
     */
    private $mockServers;

    /**
     * Name of the test suite configured in your phpunit config.
     *
     * @var
     */
    private $testSuiteNames;

    /**
     * @var \Illuminate\Support\Collection
     */
    private $mockServerConfigs;

    /** @var bool */
    private $failed;

    /**
     * @var \Illuminate\Support\Collection
     */
    private $jsonPacts;

    /**
     * PactTestListener constructor.
     *
     * @param string[] $testSuiteNames test suite names that need evaluated with the listener
     * @param string $providerName Name of provider to upload contract
     *
     */
    public function __construct(array $testSuiteNames)
    {
        $this->testSuiteNames = collect($testSuiteNames);
        $this->mockServerConfigs = collect();

        foreach ($testSuiteNames as $provider => $suite) {
            $this->mockServerConfigs->put($provider, MockServerConfigFactory::get($provider));
        }

        $this->mockServers = collect();
        $this->jsonPacts = collect();
    }

    /**
     * @param TestSuite $suite
     *
     * @throws \Exception
     */
    public function startTestSuite(TestSuite $suite): void
    {
        if ($this->testSuiteNames->contains($suite->getName())) {
            $provider = $this->testSuiteNames->flip()->get($suite->getName());


            $this->startMockServer($provider);
        }
    }

    /**
     * @param Test $test
     * @param \Throwable $t
     * @param float $time
     */
    public function addError(Test $test, \Throwable $t, float $time): void
    {
        $this->failed = true;
    }

    /**
     * @param Test $test
     * @param AssertionFailedError $e
     * @param float $time
     */
    public function addFailure(Test $test, AssertionFailedError $e, float $time): void
    {
        $this->failed = true;
    }

    /**
     * Publish JSON results to PACT Broker and stop the Mock Server.
     *
     * @param TestSuite $suite
     */
    public function endTestSuite(TestSuite $suite): void
    {
        if ($this->testSuiteNames->contains($suite->getName())) {
            $provider = $this->testSuiteNames->flip()->get($suite->getName());

            $this->stopMockServer($provider);

            if ($this->failed === true) {
                print 'A unit test has failed. Skipping PACT file upload.';
            } elseif (empty(\getenv('PACT_BROKER_URI'))) {
                print 'PACT_BROKER_URI environment variable was not set. Skipping PACT file upload.';
            } elseif (empty(\getenv('PACT_CONSUMER_VERSION'))) {
                print 'PACT_CONSUMER_VERSION environment variable was not set. Skipping PACT file upload.';
            } elseif (empty(\getenv('PACT_CONSUMER_TAG'))) {
                print 'PACT_CONSUMER_TAG environment variable was not set. Skipping PACT file upload.';
            } else {
                $this->publishPactContract($provider);
            }
        }
    }

    /**
     * @param string $provider
     * @throws \Exception
     */
    private function startMockServer(string $provider)
    {
        $this->mockServers->put(
            $provider,
            new MockServer(
                $this->mockServerConfigs->get($provider)
            )
        );

        $this->mockServers->get($provider)->start();
    }

    /**
     * @param string $provider
     */
    private function stopMockServer(string $provider)
    {
        try {
            $httpService = new MockServerHttpService(
                new GuzzleClient(),
                $this->mockServerConfigs->get($provider)
            );

            $httpService->verifyInteractions();

            $this->jsonPacts->put($provider, $httpService->getPactJson());
        } finally {
            $this->mockServers->get($provider)->stop();
        }
    }

    /**
     *
     */
    private function publishPactContract(string $provider)
    {
        $clientConfig = [];

        if (($sslVerify = \getenv('PACT_BROKER_SSL_VERIFY'))) {
            $clientConfig['verify'] = $sslVerify !== 'no';
        }

        $client = new GuzzleClient($clientConfig);

        $brokerUrl = getenv('PACT_BROKER_URI');
        $consumerVersion = getenv('PACT_CONSUMER_VERSION');
        $consumerTag = getenv('PACT_CONSUMER_TAG');

        $brokerHttpService = new BrokerHttpClient($client, new Uri($brokerUrl));
        $brokerHttpService->publishJson(
            $this->jsonPacts->get($provider),
            $consumerVersion
        );
        $brokerHttpService->tag(
            $this->mockServerConfigs->get($provider)->getConsumer(),
            $consumerVersion,
            $consumerTag
        );

        print 'Pact file has been uploaded to the Broker successfully.';
    }
}
