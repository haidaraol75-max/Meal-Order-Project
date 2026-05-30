<?php

namespace Database\Factories;

use App\Models\MenuItem;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderItem>
 */
class OrderItemFactory extends Factory
{
    
    public function definition(): array
    {
        $menuItem = MenuItem::inRandomOrder()->first();

        return [

            'price' => $menuItem->price,

            'preparation_time' => fake()->time(),

            'delivery_time' => fake()->boolean(70)
                ? fake()->time()
                : null,

            'quantity' => fake()->numberBetween(1, 5),

            'order_id' => Order::inRandomOrder()->first()->id,

            'menu_item_id' => $menuItem->id,
        ];
    }
}
