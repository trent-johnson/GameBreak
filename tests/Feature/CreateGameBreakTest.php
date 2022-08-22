<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;
use App\Models\User;

class CreateGameBreakTest extends TestCase
{
    use WithoutMiddleware;
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_create_gamebreak()
    {
        $user = User::factory()->create();

        $new_break_payload = [
            'event_datetime' => date('Y-m-d', strtotime('+7 day')),
            'location' => 'A Testing Site',
            'notes' => 'Some testing notes',
            'user_id' => $user->id,
            'rsvp_control' => 1,
            'rsvp_timing' => 24,
            'vote_control' => 1,
            'vote_timing' => 24,
            'remind_rsvp' => 1,
            'notify_vote' => 1,
            'remind_vote' => 1,
            'remind_break' => 1
        ];

        $response = $this->actingAs($user)->post('/break', $new_break_payload);

        $response->assertStatus(302);
        $this->assertDatabaseHas('break', $new_break_payload);
    }
}
