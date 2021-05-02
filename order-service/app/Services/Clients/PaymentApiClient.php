<?php

namespace App\Services\Clients;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaymentApiClient
{
    private string $baseUrl;

    public function __construct(string $baseUrl)
    {
        $this->baseUrl = $baseUrl;
    }

    public function getPaymentsByOrderId(string $orderId): Collection
    {
        $response = null;
        try {
            $response = Http::get($this->baseUrl . '/api/v1/orders/' . $orderId . '/payments');
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }

        if ($response->failed()) {
            Log::warning(json_encode($response->json()));
            throw new \Exception('An error occurred!');
        }

        return collect($response->json());
    }
}
