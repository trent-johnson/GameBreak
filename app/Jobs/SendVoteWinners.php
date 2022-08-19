<?php

namespace App\Jobs;

use App\Mail\RSVPReminder;
use App\Mail\VoteWinner;
use App\Models\GameBreak;
use App\Models\Option;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendVoteWinners implements ShouldQueue
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
        Log::debug('Job fired for sending vote winners');
        $pending_game_breaks = GameBreak::with('invitees')->where([
            ['notify_vote','=',1],
            ['vote_lock','=',1],
            ['event_datetime','<=',date('Y-m-d H:i:s', strtotime('+12 hour'))],
            ['event_datetime', '>', date('Y-m-d H:i:s')]
        ])->get();
        foreach($pending_game_breaks as $break) {

            Log::debug('Checking Game Break vote winners ' . $break->id);

            //Get votes
            $winners = $break->options()->where('winner',1)->get();

            $email_games = [];

            foreach($winners as $option) {
                //Get BGG details for the option
                $bgg_game = Cache::remember($option->bgg_thing_id . '_game',60*60*24, function () use ($option) {

                    $response = Http::get('https://boardgamegeek.com/xmlapi2/thing?id=' . $option->bgg_thing_id);

                    $xml = simplexml_load_string($response->getBody(), 'SimpleXMLElement', LIBXML_NOCDATA);
                    $json = json_encode($xml);
                    return json_decode($json, true);
                });
                $game = $bgg_game['item'];

                $email_games[] = [
                    'thumbnail' => $game['thumbnail'],
                    'name' => (count($game['name']) > 1) ? $game['name'][0]['@attributes']['value'] : $game['name']['@attributes']['value']
                ];
            }

            Log::debug('Vote winner(s): ' . print_r($email_games,true));

            if(count($email_games)) {
                foreach ($break->invitees as $remind) {
                    Log::debug('Sending vote winner to Invitee ' . $remind->id);
                    Mail::to($remind->email)->send(new VoteWinner($remind, $break, $remind->pivot->secure, $email_games));
                }
            } else {
                Log::debug('No votes were placed. Skipping vote notification');
            }
            $break->notify_vote = 2;
            $break->save();
        }
    }
}
