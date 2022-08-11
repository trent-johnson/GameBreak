<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class ShowGames extends Component
{
    public $username = '';
    public $sort = 'name';
    public $sort_asc = false;
    public $sort_options = [
        ['name' => 'Name', 'id' => 'name'],
        ['name' => 'Plays', 'id' => 'numplays'],
        ['name' => 'Release', 'id' => 'yearpublished'],
    ];
    public $search_string = null;

    public function render()
    {
        $collection = $this->fetchCollection();

        $games = $collection['item'];

        if($this->search_string)
        $games = array_filter($games, function($key) {
            return strpos($key['name'], $this->search_string);
        });

        //Apply Sorting
        usort($games, function($a, $b) {
            if($this->sort_asc) {
                return $a[$this->sort] <=> $b[$this->sort];
            } else {
                return $b[$this->sort] <=> $a[$this->sort];
            }
        });

        return view('livewire.show-games', [
            'games' => $games,
            'sort' => $this->sort,
            'sort_asc' => $this->sort_asc,
            'sort_options' => $this->sort_options
        ]);
    }

    public function sort($type) {
        Log::debug('Sort requested: ' . $type);
        if($type == $this->sort) {
            $this->sort_asc = !($this->sort_asc == true);
        }
        $this->sort = $type;
    }
    public function search($search_string) {
        $this->search_string = $search_string;
    }

    private function fetchCollection() {
        return  Cache::remember($this->username . '_collection',60*60*24, function () {
            $response = Http::get('https://boardgamegeek.com/xmlapi2/collection?username=' . $this->username . '&subtype=boardgame&own=1');
            $xml = simplexml_load_string($response->getBody(), 'SimpleXMLElement', LIBXML_NOCDATA);
            $json = json_encode($xml);
            return json_decode($json, true);
        });
    }

    public function test() {
        Log::debug('Test method fired!');
    }
}
