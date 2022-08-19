<?php

namespace App\Http\Livewire;

use App\Mail\AcceptedInvite;
use App\Models\GameBreak;
use App\Models\Invitee;
use Livewire\Component;
use Illuminate\Support\Facades\Mail;

class InviteControl extends Component
{
    public Invitee $invitee;
    public GameBreak $break;
    public $secure;
    public $invite_status = 0;

    public function mount() {
        $record = $this->break->invitees()->where('invitee_id', $this->invitee->id)->first();
        $this->invite_status = $record->pivot->status;
        $this->secure = $record->pivot->secure;
    }
    public function render()
    {
        return view('livewire.invite-control');
    }

    public function updateStatus($status) {
        if($status == 'Accept') {
            $this->invite_status = 1;
            $this->emit('rsvpAccepted');

            Mail::to($this->invitee->email)
                ->queue(new AcceptedInvite($this->invitee, $this->break, $this->secure));

        } else {
            $this->invite_status = 2;
            $this->break->votes()->where('invitee_id',$this->invitee->id)->delete();
        }
        $this->break->invitees()->updateExistingPivot($this->invitee->id, ['status' => $this->invite_status]);
    }
}
