<?php

namespace EddIriarte\Order\Http\Controllers;

use Laravel\Lumen\Routing\Controller;
use Illuminate\Http\Request;
use EddIriarte\Order\Order;

class GetOrdersByConsumerId extends Controller
{
    public function __invoke(Request $request, $consumerId)
    {
        $orders = Order::where('consumer_id', '=', "'$consumerId'")->get();

        return response()->json($orders);
    }
}
