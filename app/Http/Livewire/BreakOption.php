<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Option;
use Livewire\Component;

class BreakOption extends Component
{
    public $option_id;
    public $thing_id;
    public $invitee_id;
    public $game;

    public function mount() {
        $bgg_game = Cache::remember($this->thing_id . '_game',60*60*24, function () {

            $response = Http::get('https://boardgamegeek.com/xmlapi2/thing?id=' . $this->thing_id);

            $xml = simplexml_load_string($response->getBody(), 'SimpleXMLElement', LIBXML_NOCDATA);
            $json = json_encode($xml);
            return json_decode($json, true);
        });
        $this->game = $bgg_game['item'];
    }

    public function render()
    {
        return view('livewire.break-option');
    }

    public function vote($invitee_id) {
        Log::debug('Vote received!');
        $option = Option::find($this->option_id);
        $option->votes()->create(['invitee_id' => $invitee_id]);
    }
}
