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
    public $max_players = 8;
    public $min_players = 1;
    public $max_time = 360;
    public $min_time = 15;

    public function render()
    {
        $collection = $this->fetchCollection();

        //Need to check if the processing request response was return and try again if so.

        $games = $collection['item'];

        //Apply Search filter
        if($this->search_string) {
            $games = array_filter($games, function ($key) {
                return strpos(strtolower($key['name']), strtolower($this->search_string)) !== false;
            });
        }

        //Player Count Filters
        if($this->max_players) {
            $games = array_filter($games, function ($key) {
                    return ($this->max_players <> 8) ? $key['stats']['@attributes']['maxplayers'] <= $this->max_players : true;
            });
        }
        if($this->min_players) {
            $games = array_filter($games, function ($key) {
                return $key['stats']['@attributes']['minplayers'] >= $this->min_players;
            });
        }

        //Time Filter
        if($this->max_time) {
            $games = array_filter($games, function ($key) {
                return ($this->max_time <> 360 && array_key_exists('playingtime',$key['stats']['@attributes'])) ? $key['stats']['@attributes']['playingtime'] <= $this->max_time : true;
            });
        }

        if($this->min_time) {
            $games = array_filter($games, function ($key) {
                return (array_key_exists('playingtime',$key['stats']['@attributes'])) ? $key['stats']['@attributes']['playingtime'] >= $this->min_time : true;
            });
        }


        //Apply Sorting
        usort($games, function($a, $b) {
            if($this->sort_asc) {
                return $a[$this->sort] <=> $b[$this->sort];
            } else {
                return $b[$this->sort] <=> $a[$this->sort];
            }
        });

        Log::debug(print_r($games,true));

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

    private function fetchCollection() {
        return  Cache::remember($this->username . '_collection',60*60*24, function () {
            $response = Http::get('https://boardgamegeek.com/xmlapi2/collection?username=' . $this->username . '&subtype=boardgame&own=1&stats=1');
            $xml = simplexml_load_string($response->getBody(), 'SimpleXMLElement', LIBXML_NOCDATA);
            $json = json_encode($xml);
            return json_decode($json, true);
        });
    }

    public function test() {
        Log::debug('Test method fired!');
    }
}
