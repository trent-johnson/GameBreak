<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateGameGroupTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_create_game_group()
    {
        $user = User::factory()->create();

        $new_group_payload = [
            'name' => 'Test Game Group',
            'description' => 'Test Game Group Description'
        ];

        $response = $this->actingAs($user)->post('/group', $new_group_payload);

        $response->assertStatus(302);
        $this->assertDatabaseHas('game_group', $new_group_payload);
    }
}
