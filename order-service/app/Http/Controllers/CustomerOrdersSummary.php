<?php

namespace App\Http\Controllers;

    use App\Models\Order;
    use Illuminate\Http\Request;

class CustomerOrdersSummary extends \Laravel\Lumen\Routing\Controller
{
    public function __invoke(string $customer_id, Request $request)
    {
        $orders = Order::where('customer_id', '=', (int)$customer_id)->get();

        $summary = collect($orders)
            ->map(fn ($record) => [
                'id' => $record->id,
                'customer_id' => $record->customer_id,
                'ordered_at' => $record->ordered_at,
                'address' => $record->address,
                'gross_total' => $record->gross_total,
                'tax_rate' => $record->tax_rate,
                'currency' => $record->currency,
            ]);

        return response()->json($summary);
    }
}
