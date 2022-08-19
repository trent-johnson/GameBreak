<?php

namespace App\Jobs;

use App\Mail\BreakInvite;
use App\Mail\RSVPReminder;
use App\Models\GameBreak;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendRSVPReminders implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;



    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::debug('Job fired for sending Game Break reminders from now to ' . date('Y-m-d H:i:s', strtotime('+24 hour')));
        $pending_game_breaks = GameBreak::with('invitees')->where([
            ['remind_rsvp','=',1],
            ['event_datetime','<=',date('Y-m-d H:i:s', strtotime('+48 hour'))],
            ['event_datetime', '>', date('Y-m-d H:i:s')]
        ])->get();
        foreach($pending_game_breaks as $break) {

            Log::debug('Checking Game Break ' . $break->id);
            foreach($break->invitees->where('status',0) as $remind) {

                Log::debug('Sending reminder to Invitee ' . $remind->id);
                Mail::to($remind->email)->send(new RSVPReminder($remind, $break, $remind->pivot->secure));
            }
            $break->remind_rsvp = 2;
            $break->save();
        }
    }
}
