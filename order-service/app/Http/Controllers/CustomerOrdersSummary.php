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
                'customer_id' => (int)$record->customer_id,
                'ordered_at' => \Carbon\Carbon::parse($record->ordered_at)->toW3cString(),
                'address' => $record->address,
                'gross_total' => (float)$record->gross_total,
                'tax_rate' => (float)$record->tax_rate,
                'currency' => $record->currency,
            ]);

        return response()->json($summary);
    }
}
