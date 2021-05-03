<?php


namespace App\Http\Controllers;


use App\Models\Order;
use App\Services\Clients\CustomerApiClient;
use App\Services\Clients\PaymentApiClient;
use Illuminate\Support\Collection;

class OrderDetails extends \Laravel\Lumen\Routing\Controller
{
    private CustomerApiClient $customerApi;
    private PaymentApiClient $paymentApi;

    public function __construct(CustomerApiClient $customerApi, PaymentApiClient $paymentApi)
    {
        $this->customerApi = $customerApi;
        $this->paymentApi = $paymentApi;
    }

    public function __invoke(string $order_id)
    {
        $order = Order::find($order_id);

        $details = [
            'id' => $order->id,
            'ordered_at' => $order->ordered_at,
            'address' => $order->address,
            'gross_total' => (float)$order->gross_total,
            'tax_rate' => (float)$order->tax_rate,
            'currency' => $order->currency,
            'basket' => $this->decodeBasket($order->basket),
            'payments' => $this->getOrderPayments($order->id),
//            'customer' => $this->getOrderCustomer($order->customer_id),
        ];

        return response()->json($details);
    }

    private function getOrderPayments(string $orderId): Collection
    {
        return $this->paymentApi->getPaymentsByOrderId($orderId);
    }

    private function getOrderCustomer(string $customerId)
    {
        return $this->customerApi->getCustomerById($customerId);
    }

    private function decodeBasket(string $basket): Collection
    {
        $items = json_decode($basket, true);

        return collect($items);
    }
}
