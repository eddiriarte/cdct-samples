<?php

namespace EddIriarte\Order\Gateway;

use GuzzleHttp\Exception\RequestException;

class PaymentGateway extends ApiGateway
{
    /**
     * @param string $orderId
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function getPaymentsByOrderId(string $orderId)
    {
        try {
            $response = $this->client->request(
                'GET',
                $this->baseUrl . '/payments/by-order/' . $orderId,
                [
                    'headers' => [
                        'Content-Type' => 'application/json',
                    ],
                ]
            );

            return $response;
        } catch (\GuzzleHttp\Exception\GuzzleException $e) {
            // log this error!

            return null;
        }

    }
}
