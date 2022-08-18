<?php

namespace App\Http\Livewire;

use App\Models\GameBreak;
use App\Models\Invitee;
use Livewire\Component;

class InviteControl extends Component
{
    public Invitee $invitee;
    public GameBreak $break;
    public $secure;
    public $invite_status = 0;

    public function mount() {
        $record = $this->break->invitees()->where('invitee_id', $this->invitee->id)->first();
        $this->invite_status = $record->pivot->status;
    }
    public function render()
    {
        return view('livewire.invite-control');
    }

    public function updateStatus($status) {
        if($status == 'Accept') {
            $this->invite_status = 1;
            $this->emit('rsvpAccepted');
        } else {
            $this->invite_status = 2;
        }
        $this->break->invitees()->updateExistingPivot($this->invitee->id, ['status' => $this->invite_status]);
    }
}
