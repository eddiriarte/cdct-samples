<?php

namespace App\Services\Clients;

class CustomerApiClient
{
    private string $baseUrl;

    public function __construct(string $baseUrl)
    {
        $this->baseUrl = $baseUrl;
    }


}
