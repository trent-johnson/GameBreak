<?php

namespace Tests\Feature\Jobs;

use App\Jobs\CalcVoteWinners;
use App\Models\GameBreak;
use App\Models\Vote;
use App\Models\Option;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class CalcVoteWinnersTest extends TestCase
{

    use RefreshDatabase;
    use WithoutMiddleware;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_calculating_vote_winners()
    {
        $break = GameBreak::factory()
            ->has(Option::factory()->count(4))
            ->create([
            'vote_lock' => 0,
            'vote_control' => 1,
            'event_datetime' => date('Y-m-d H:i:s', strtotime('+8 hours')),
            'vote_timing' => 12
        ]);

        $winning_option = $break->options()->first();
        Vote::factory()->count(4)->create(['option_id' => $winning_option->id]);

        CalcVoteWinners::dispatch();

        $this->assertDatabaseHas('break', [
            'vote_lock' => 1
        ]);

        $this->assertDatabaseHas('options',[
            'id' => $winning_option->id,
            'winner' => 1
        ]);
    }
}
