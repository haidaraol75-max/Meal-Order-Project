<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MenuItem>
 */
class MenuItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->randomElement([
                'Burger',
                'Pizza',
                'Pasta',
                'Chicken Sandwich',
                'Fries',
                'Cola',
                'Orange Juice',
                'Ice Cream',
            ]),

            'price' => fake()->randomFloat(2, 5, 100),

            'description' => fake()->sentence(),

            'availability' => fake()->boolean(90),

            'category_id' => Category::inRandomOrder()->first()->id,
        ];
    }
}
