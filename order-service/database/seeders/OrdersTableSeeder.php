<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class OrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $orders = json_decode(file_get_contents(__DIR__ . '/_data/orders.json'), true);

        foreach ($orders as $data) {
            Order::factory()->create($data);
        }
    }
}
