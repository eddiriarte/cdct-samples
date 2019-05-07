<?php

namespace Test\Order\Contracts\Payment;

use EddIriarte\Order\Gateway\PaymentGateway;
use GuzzleHttp\Client;
use PhpPact\Consumer\InteractionBuilder;
use PhpPact\Consumer\Matcher\Matcher;
use PhpPact\Consumer\Model\ConsumerRequest;
use PhpPact\Consumer\Model\ProviderResponse;
use PHPUnit\Framework\TestCase;
use Tests\Order\Support\MockServerConfigFactory;

class NoPaymentsByOrderIdFoundContract extends TestCase
{
    /**
     * @test
     * @throws \Exception
     */
    function it_should_not_find_any_payment_data()
    {
        // Create your expected request from the consumer.
        $request = (new ConsumerRequest())
            ->setMethod('GET')
            ->setPath('/payments/by-order/d50a2be4-f288-3e93-a3a6-cec278b6b50a');

        // Create your expected response from the provider.
        $response = (new ProviderResponse())
            ->setStatus(404)
            ->addHeader('Content-Type', 'application/json;charset=utf-8')
            ->setBody(
                $this->getVerifiableResponse(new Matcher())
            );

        $config = MockServerConfigFactory::get('payment-service');

        // Create a configuration that reflects the server that was started. You can create a custom MockServerConfigInterface if needed.
        $builder = new InteractionBuilder($config);
        $builder
            ->given('not existent order_id d50a2be4-f288-3e93-a3a6-cec278b6b50a')
            ->uponReceiving('request for payments by order_id')
            ->with($request)
            ->willRespondWith($response); // This has to be last. This is what makes an API request to the Mock Server to set the interaction.

        $result = (new PaymentGateway(new Client(), (string)$config->getBaseUri()))
            ->getPaymentsByOrderId('d50a2be4-f288-3e93-a3a6-cec278b6b50a');

        $builder->verify(); // This will verify that the interactions took place.

        $this->assertEmpty($result);
    }

    /**
     * @param Matcher $matcher
     * @return array
     */
    public function getVerifiableResponse(Matcher $matcher)
    {
        return null;
    }
}
