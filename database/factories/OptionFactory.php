<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Option>
 */
class OptionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'bgg_thing_id' => fake()->randomElement([248490]),
            'break_id' => fake()->randomNumber(3),
            'winner' => fake()->randomElement([0,1])
        ];
    }
}
