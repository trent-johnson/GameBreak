<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GameBreak>
 */
class GameBreakFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'event_datetime' => fake()->dateTime(),
            'location' => fake()->address(),
            'notes' => fake()->sentence(),
            'user_id' => fake()->randomNumber(),
            'vote_timing' => fake()->numberBetween(1,36),
            'rsvp_timing' => fake()->numberBetween(1,36),
            'rsvp_lock' => fake()->numberBetween(1,2),
            'vote_lock' => fake()->numberBetween(1,2),
            'rsvp_control' => fake()->numberBetween(1,2),
            'vote_control' => fake()->numberBetween(1,2),
            'rsvp_limit' => fake()->numberBetween(1,100),
            'vote_limit' => fake()->numberBetween(1,10),
            'remind_rsvp' => fake()->numberBetween(1,3),
            'remind_vote' => fake()->numberBetween(1,3),
            'notify_vote' => fake()->numberBetween(1,3),
            'remind_break' => fake()->numberBetween(1,3),
            'invitee_limit' => fake()->numberBetween(1,100),
        ];;
    }
}
