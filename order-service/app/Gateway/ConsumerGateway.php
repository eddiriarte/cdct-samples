<?php

namespace EddIriarte\Order\Gateway;


class ConsumerGateway extends ApiGateway
{
    /**
     * @param string $consumerId
     * @param string $addressId
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function findConsumerWithAddress(string $consumerId, string $addressId)
    {
        try {
            $response = $this->client->request(
                'GET',
                sprintf(
                    '%s/consumers/%s/addresses/%s',
                    $this->baseUrl,
                    $consumerId,
                    $addressId
                ),
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
