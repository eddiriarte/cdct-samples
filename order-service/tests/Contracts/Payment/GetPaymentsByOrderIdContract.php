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

class GetPaymentsByOrderIdContract extends TestCase
{
    /**
     * @test
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function it_should_retrieve_valid_payment_data()
    {
        // Create your expected request from the consumer.
        $request = (new ConsumerRequest())
            ->setMethod('GET')
            ->setPath('/payments/by-order/d50a2be4-f288-3e93-a3a6-7aa483445c03');

        // Create your expected response from the provider.
        $response = (new ProviderResponse())
            ->setStatus(200)
            ->addHeader('Content-Type', 'application/json;charset=utf-8')
            ->setBody(
                $this->getVerifiableResponse(new Matcher())
            );

        $config = MockServerConfigFactory::get('payment-service');

        // Create a configuration that reflects the server that was started. You can create a custom MockServerConfigInterface if needed.
        $builder = new InteractionBuilder($config);
        $builder
            ->given('existent order_id d50a2be4-f288-3e93-a3a6-7aa483445c03')
            ->uponReceiving('request for payments by order_id')
            ->with($request)
            ->willRespondWith($response); // This has to be last. This is what makes an API request to the Mock Server to set the interaction.

        $result = (new PaymentGateway(new Client(), (string)$config->getBaseUri()))
            ->getPaymentsByOrderId('d50a2be4-f288-3e93-a3a6-7aa483445c03');

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
            $matcher->eachLike(
                [
                    'id' => $matcher->uuid(),
                    'order_id' => $matcher->uuid(),
                    'payment_date' => $matcher->term(
                        '2019-05-07 18:30:00',
                        '^\\d{4}-\\d{2}-\\d{2} \\d{2}:\\d{2}:\\d{2}$'
                    ),
                    'amount' => $matcher->decimal(),
                    'iban' => $matcher->like('AT549804124646222075'),
                ]
            )
        ];
    }
}
