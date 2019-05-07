<?php

namespace Test\Order\Contracts\Web;

use PHPUnit\Framework\TestCase;
use PhpPact\Standalone\ProviderVerifier\Model\VerifierConfig;
use GuzzleHttp\Psr7\Uri;
use PhpPact\Standalone\ProviderVerifier\Verifier;

class VerifyWebPortalContract extends TestCase
{
    public function testProviderSatisfiesWebPortalsContract()
    {
        $config = new VerifierConfig();
        $config
            ->setProviderName('order-service') // Providers name to fetch.
            ->setProviderVersion('1.0.0')
            ->setProviderBaseUrl(new Uri('http://order-service.local')) // URL of the Provider.
            ->setBrokerUri(new Uri('http://pact-broker.local')) // URL of the Pact Broker to publish results.
            ->setPublishResults(true) // Flag the verifier service to publish the results to the Pact Broker.
            ->setProcessTimeout(60)
            ->setProcessIdleTimeout(20)
            ->setProviderStatesSetupUrl('http://order-service.local/pact-dev/provider-state');

        // Verify that all consumers of 'someProvider' are valid.
        $verifier = new Verifier($config);
        $verifier->verifyAll();

        // This will not be reached if the PACT verifier throws an error, otherwise it was successful.
        $this->assertTrue(true, 'Pact Verification has failed.');
    }
}
