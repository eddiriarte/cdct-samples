<?php

namespace Tests\Providers;


use GuzzleHttp\Psr7\Uri;
use PhpPact\Standalone\ProviderVerifier\Model\VerifierConfig;
use PhpPact\Standalone\ProviderVerifier\Verifier;
use Tests\TestCase;

class OrderProviderTest extends TestCase
{
    /**
     * @test
     */
    public function it_verifies_all_contracts_for_provider()
    {
        $config = new VerifierConfig();
        $config
            ->setProviderName('Order Api') // Providers name to fetch.
            ->setProviderVersion('1.0.0') // Providers version.
            ->setProviderBaseUrl(new Uri('http://localhost')) // URL of the Provider.
            ->setBrokerUri(new Uri('http://pact-broker')) // URL of the Pact Broker to publish results.
            ->setPublishResults(true) // Flag the verifier service to publish the results to the Pact Broker.
            ->setProcessTimeout(60)      // Set process timeout (optional) - default 60
            ->setProcessIdleTimeout(10) // Set process idle timeout (optional) - default 10
            ->setEnablePending(true) // Flag to enable pending pacts feature (check pact docs for further info)
            ->setIncludeWipPactSince('2020-01-30'); //Start date of WIP Pacts (check pact docs for further info);

        // Verify that the Consumer 'someConsumer' that is tagged with 'master' is valid.
        $verifier = new Verifier($config);
        $verifier->verifyAll();

        // This will not be reached if the PACT verifier throws an error, otherwise it was successful.
        self::assertTrue(true, 'Pact Verification has failed.');
    }
}
