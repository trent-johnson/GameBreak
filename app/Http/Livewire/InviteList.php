<?php

namespace App\Http\Livewire;


use App\Models\GameBreak;
use Livewire\Component;

class InviteList extends Component
{
    public GameBreak $break;

    public function render()
    {
        return view('livewire.invite-list');
    }
}
