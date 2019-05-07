<?php

namespace EddIriarte\Order\Gateway;

use GuzzleHttp\Client;

class ApiGateway
{
    /**
     * @var \GuzzleHttp\Client
     */
    protected $client;

    /**
     * @var string
     */
    protected $baseUrl;

    public function __construct(Client $client, string $baseUrl)
    {
        $this->client = $client;
        $this->baseUrl = $baseUrl;
    }
}
