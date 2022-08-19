<?php

namespace App\Jobs;

use App\Models\GameBreak;
use App\Models\Option;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class CalcVoteWinners implements ShouldQueue
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
        Log::debug('Job fired for calculating vote winners.');
        $pending_game_breaks = GameBreak::with('invitees')->where([
            ['vote_control','=',1],
            ['vote_lock','=',0],
            ['event_datetime','<=',date('Y-m-d H:i:s', strtotime('+24 hour'))],
            ['event_datetime', '>', date('Y-m-d H:i:s')]
        ])->get();
        foreach($pending_game_breaks as $break) {

            Log::debug('Checking Game Break vote winner status  ' . $break->id);

            //Get votes
            $votes = $break->votes()->get();

            //Group votes
            $counts = $votes->countBy('option_id');

            //Determine vote count that is the highest
            $max = $votes->countBy('option_id')->max();

            //Retrieve any options that = the max. Could be ties...
            $winner = $counts->where(function ($value, $key) use($max) {
                return $value == $max;
            });

            //Collect the wining option(s)
            $winning_options = Option::find($winner->keys());

            //Set the winner flags for the votes that won.
            foreach($winning_options as $winner) {
                $winner->winner = 1;
                $winner->save();
            }
            Log::debug('Locking the voting');
            //Lock the voting
            $break->vote_lock = 1;
            $break->save();
        }
    }
}
