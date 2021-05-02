<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id' => $this->faker->uuid,
            'customer_id' => $this->faker->randomDigitNotNull,
            'ordered_at' => $this->faker->dateTimeBetween('-2 years', '-1 month'),
            'address' => $this->faker->address,
            'gross_total' => $this->faker->numberBetween(100, 500),
            'tax_rate' => $this->faker->randomElement([19, 17.5, 7, 5, 7.5, 2.7]),
            'currency' => $this->faker->randomElement(['EUR', 'CHF']),
            'basket' => function (array $attributes) {
                return $this->buildBasket($attributes['gross_total'], $attributes['tax_rate']);
            },
        ];
    }

    private function buildBasket($grossTotal, $taxRate): string
    {
        $totalArticles = $this->faker->numberBetween(1, 3);
        $restAmount = $grossTotal;

        $articles = [];

        for ($i = 0; $i < $totalArticles; $i++) {
            $unit_price_gross = $this->faker->randomFloat(2, 10, $restAmount);
            if (($i+1) === $totalArticles) {
                $unit_price_gross = $restAmount;
            }

            $restAmount -= $unit_price_gross;

            $tax_rate = $taxRate;

            $quantity = 1;

            $article_number = $this->faker->bothify('??###-###');

            $description = implode(' ', [
                $this->faker->randomElement(['Fancy', 'Fluffy', 'Amazing', 'Crazy', 'Crunchy', 'Lazy', 'Hammer', 'Monster', 'Gentle', 'Fuzzy', 'Proper', 'Reasonable', 'Exploding', 'Rigorous']),
                $this->faker->colorName,
                $this->faker->city,
                $this->faker->randomElement(['Banana-Bread', 'Slippers', 'Liquours', 'Candles', 'Towels', 'Rubber-Duck', 'Cereals', 'Door-Bell', 'Pinata', 'Tea-Pot']),
            ]);

            $articles[] = compact('article_number', 'description', 'quantity', 'unit_price_gross', 'tax_rate');
        }

        return json_encode($articles);
    }
}
