<?php


namespace App\Services\Clients;


use App\Domain\Order\Order;
use App\Domain\Order\OrderDetails;
use App\Exceptions\OrderApiRequestException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class OrderApiClient
{
    /**
     * @var string
     */
    private $baseUrl;

    public function __construct(string $baseUrl)
    {
        $this->baseUrl = $baseUrl;
    }

    public function getOrdersByUserId(string $userId): Collection
    {
        $response = null;
        try {
            $response = Http::withHeaders(['Content-Type' => 'application/json'])
                ->get($this->baseUrl . '/api/v1/customers/' . $userId . '/orders');
        } catch (\Exception $e) {
            throw new OrderApiRequestException('An error occurred!');
        }

        if ($response->failed()) {
            throw new OrderApiRequestException($response->body());
        }

        return collect($response->json())
            ->map(fn ($order) => Order::make($order));
    }

    public function getOrderDetails(string $orderId): OrderDetails
    {
        try {
            $response = Http::withHeaders(['Content-Type' => 'application/json'])
                ->get($this->baseUrl . '/api/v1/orders/' . $orderId);

            return OrderDetails::make($response->json());
        } catch (\Exception $e) {

        }
    }
}
