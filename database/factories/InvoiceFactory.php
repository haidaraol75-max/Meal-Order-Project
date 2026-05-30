<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
{
     public function definition(): array
    {
        $order = Order::doesntHave('invoice')
            ->inRandomOrder()
            ->first();

        return [

             'quantity' => fake()->numberBetween(1, 5),
             'amount' => fake()->randomFloat(2, 20, 500),
             'payment_time' => fake()->boolean(80) ? fake()->dateTime() : null,
             'order_id' => null, 
             'table_id' => null,
        ];
    }
}
