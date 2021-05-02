<?php


namespace App\Http\Controllers;


use App\Domain\Auth\AuthenticatedUser;
use App\Services\Clients\OrderApiClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;

class OrderSummary extends \Laravel\Lumen\Routing\Controller
{
    private OrderApiClient $orderApi;

    public function __construct(OrderApiClient $orderApi)
    {
        $this->orderApi = $orderApi;
    }

    public function __invoke(Request $request)
    {
        if (!Cookie::has('auth') || !Cache::has(Cookie::get('auth'))) {
            return redirect('/');
        }

        $user = AuthenticatedUser::make(json_decode(Cache::get(Cookie::get('auth')), true));

        $orders = $this->orderApi->getOrdersByUserId($user->getId());

        return view('orders.summary')
            ->with('orders', $orders);
    }
}
