<?php

namespace Database\Factories;

use App\Models\RestaurantTable;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $orderType = fake()->randomElement([
                'dine_in',
                'takeaway'
            ]);
        return [
            
            'order_type' => $orderType,

            'order_status' => fake()->randomElement([
                'Preparing',
                'Ready',
                'Delivered'
            ]),

            'order_date' => fake()->date(),

            'order_time' => fake()->time(),

            'total_amount' => fake()->randomFloat(2, 20, 500),

            'table_id' => $orderType == 'dine_in'
                ? RestaurantTable::inRandomOrder()->first()->id : null,
        ];
    }
}
