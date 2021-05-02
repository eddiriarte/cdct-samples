<?php


namespace App\Http\Controllers;


use App\Domain\Auth\AuthenticatedUser;
use App\Services\Clients\OrderApiClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;

class OrderDetails extends \Laravel\Lumen\Routing\Controller
{
    private OrderApiClient $orderApi;

    public function __construct(OrderApiClient $orderApi)
    {
        $this->orderApi = $orderApi;
    }

    public function __invoke(string $order_id, Request $request)
    {
        if (!Cookie::has('auth') || !Cache::has(Cookie::get('auth'))) {
            return redirect('/');
        }

        $order = $this->orderApi->getOrderDetails($order_id);

        return view('orders.details')
            ->with('order', $order);
    }
}
