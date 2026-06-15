<?php

namespace Database\Factories;

use App\Models\Board;
use App\Models\BoardList;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<BoardList>
 */
class BoardListFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->randomElement(['To Do', 'In Progress', 'Done']),
            'board_id' => Board::factory(),
        ];
    }
}
