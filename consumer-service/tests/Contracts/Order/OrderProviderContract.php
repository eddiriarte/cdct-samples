<?php

namespace Tests\Consumer\Contracts\Order;


use GuzzleHttp\Psr7\Uri;
use PhpPact\Standalone\ProviderVerifier\Model\VerifierConfig;
use PhpPact\Standalone\ProviderVerifier\Verifier;
use PHPUnit\Framework\TestCase;

class OrderProviderContract extends TestCase
{
    public function testProviderSatisfiesOrderServiceContract()
    {
        $config = new VerifierConfig();
        $config
            ->setProviderName('consumer-service') // Providers name to fetch.
            ->setProviderVersion('1.0.0')
            ->setProviderBaseUrl(new Uri('http://consumer-service.local')) // URL of the Provider.
            ->setBrokerUri(new Uri('http://pact-broker.local')) // URL of the Pact Broker to publish results.
            ->setPublishResults(true) // Flag the verifier service to publish the results to the Pact Broker.
            ->setProcessTimeout(60)
            ->setVerbose(true)
            ->setProcessIdleTimeout(20)
            ->setProviderStatesSetupUrl('http://consumer-service.local/api/users/dev/provider-state');

        // Verify that all consumers of 'someProvider' are valid.
        $verifier = new Verifier($config);
        $verifier->verify('order-service');  //verifyAll();

        // This will not be reached if the PACT verifier throws an error, otherwise it was successful.
        $this->assertTrue(true, 'Pact Verification has failed.');
    }
}