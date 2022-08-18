<?php

namespace App\Http\Livewire;

use App\Models\Invitee;
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
    public Invitee $invitee;
    public $game;
    public $disabled = true;
    public $option;
    public $can_vote = false;
    public $vote_cta = 'Vote!';
    public $vote_status = 0;

    protected $listeners = ['votePlaced','rsvpAccepted'];

    public function mount() {
        $bgg_game = Cache::remember($this->thing_id . '_game',60*60*24, function () {

            $response = Http::get('https://boardgamegeek.com/xmlapi2/thing?id=' . $this->thing_id);

            $xml = simplexml_load_string($response->getBody(), 'SimpleXMLElement', LIBXML_NOCDATA);
            $json = json_encode($xml);
            return json_decode($json, true);
        });
        $this->game = $bgg_game['item'];

        $this->option = Option::find($this->option_id);

        if($this->invitee_id && $this->option->break->invitees()->where('invitee_id',$this->invitee_id)->first()->pivot->status == 1) {

            $this->can_vote = true;

            if ($this->option->break->votes->doesntContain('invitee_id', $this->invitee_id)) {
                $this->disabled = false;
                $this->vote_status = 0;
            } elseif ($this->option->break->votes->where('invitee_id', $this->invitee_id)->where('option_id', $this->option->id)->count()) {
                Log::debug('Your choice ' . $this->invitee_id . ' and ' . $this->option->id);
                $this->vote_cta = 'Your Choice!';
                $this->vote_status = 1;
            } else {
                $this->vote_cta = 'Already Voted';
                $this->vote_status = 2;
            }
        }
    }

    public function render()
    {
        return view('livewire.break-option');
    }

    public function vote($invitee_id) {
        Log::debug('Vote received!');

        //Confirm can vote:
        if($this->option->break->votes->where('invitee_id', $this->invitee_id)->count() < 1) {
            $this->emit('votePlaced', $this->option);
            $this->option->votes()->create(['invitee_id' => $invitee_id]);
            $this->disabled = true;
            $this->vote_status = 1;
            $this->vote_cta = 'Your Choice!';
        }
    }

    public function votePlaced(Option $option) {
        if($option->id <> $this->option_id) {
            $this->disabled = true;
            $this->vote_cta = 'Already Voted';
            $this->vote_status = 2;
        }
    }

    public function rsvpAccepted() {
        $this->can_vote = true;
        $this->disabled = false;
    }
}
