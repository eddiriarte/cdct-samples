<?php

namespace EddIriarte\WebPortal\Gateway;

use GuzzleHttp\Client;

class ConsumerClient
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var string
     */
    private $baseUrl;

    /**
     * ConsumerClient constructor.
     * @param Client $client
     * @param string $baseUrl
     */
    public function __construct(Client $client, string $baseUrl)
    {
        $this->client = $client;
        $this->baseUrl = $baseUrl;
    }

    /**
     * @param string $email
     * @param string $password
     * @return \Psr\Http\Message\ResponseInterface
     * @throws
     */
    public function verifyConsumerCredentials(string $email, string $password)
    {
        return $this->client
            ->request(
                'POST',
                $this->baseUrl . '/consumers/verify',
                [
                    'headers' => [
                        'Content-Type' => 'application/json'
                    ],
                    'body' => json_encode(compact('email', 'password')),
                    'http_errors' => false
                ]
            );
    }
}
