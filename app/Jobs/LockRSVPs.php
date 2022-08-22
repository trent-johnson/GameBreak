<?php

namespace App\Jobs;

use App\Mail\RSVPReminder;
use App\Models\GameBreak;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class LockRSVPs implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::debug('Job fired for locking in RSVPs');
        $pending_game_breaks = GameBreak::with('invitees')->where([
            ['rsvp_control','=',1],
            ['rsvp_lock','=',0],
            ['event_datetime', '>', date('Y-m-d H:i:s')]
        ])->whereRaw('event_datetime <= NOW() + INTERVAL rsvp_timing HOUR')->get();
        foreach($pending_game_breaks as $break) {

            $reminders = $break->invitees()->where('status',0)->get();
            foreach($reminders as $remind) {
                Log::debug('Auto declining pending invitation for break ' . $break->id . ' and invite ' . $remind->id);
                $break->invitees()->updateExistingPivot($remind->id, ['status' => 2]);
            }

            $break->rsvp_lock = 1;
            $break->save();
        }
    }
}
