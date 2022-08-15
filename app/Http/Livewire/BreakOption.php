<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class BreakOption extends Component
{
    public $option_id;
    public $thing_id;
    public function render()
    {
        $game = Cache::remember($this->thing_id . '_game',60*60*24, function () {

            $response = Http::get('https://boardgamegeek.com/xmlapi2/thing?id=' . $this->thing_id);

            $xml = simplexml_load_string($response->getBody(), 'SimpleXMLElement', LIBXML_NOCDATA);
            $json = json_encode($xml);
            return json_decode($json, true);
        });

        return view('livewire.break-option', [
            'game' => $game['item'],
            'thing_id' => $this->thing_id
        ]);
    }
}
