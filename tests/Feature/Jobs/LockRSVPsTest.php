<?php

namespace Tests\Feature\Jobs;

use App\Jobs\LockRSVPs;
use App\Models\GameBreak;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class LockRSVPsTest extends TestCase
{
    use RefreshDatabase;
    use WithoutMiddleware;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_rsvp_job_locking()
    {

        //This game break should have RSVPs locked after job execution.
        $break = GameBreak::factory()->create([
            'event_datetime' => date('Y-m-d H:i:s', strtotime('+ 3 hour')),
            'rsvp_lock' => 0,
            'rsvp_control' => 1,
            'rsvp_timing' => 12
        ]);

        //These breaks should not be locked.
        $no_touch_1 = GameBreak::factory()->create([
            'event_datetime' => date('Y-m-d H:i:s', strtotime('+ 24 hour')),
            'rsvp_lock' => 0,
            'rsvp_control' => 1,
            'rsvp_timing' => 12
        ]);
        $no_touch_2 = GameBreak::factory()->create([
            'event_datetime' => date('Y-m-d H:i:s', strtotime('+ 3 hour')),
            'rsvp_lock' => 0,
            'rsvp_control' => 0,
            'rsvp_timing' => 12
        ]);
        LockRSVPs::dispatch();

        $this->assertDatabaseHas('break',
            ['id' => $break->id, 'rsvp_lock' => 1]);
        $this->assertDatabaseHas('break',
            ['id' => $no_touch_1->id, 'rsvp_lock' => 0]);
        $this->assertDatabaseHas('break',
            ['id' => $no_touch_1->id, 'rsvp_lock' => 0]);
    }
}
