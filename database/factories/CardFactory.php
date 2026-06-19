<?php

namespace Database\Factories;

use App\Models\Card;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Card>
 */
class CardFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(),
            'position' => fake()->randomElement([1,2,3,4,5,6,7,8,9,10]),
            'due_date' => fake()->date(),
            'description' => fake()->sentence(),
            'is_completed' => fake()->boolean(),
        ];
    }
}
