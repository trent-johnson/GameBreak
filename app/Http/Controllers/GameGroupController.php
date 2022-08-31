<?php

namespace App\Http\Controllers;

use App\Mail\BreakInvite;
use App\Models\GameGroup;
use App\Models\Invitee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class GameGroupController extends Controller
{
    public function save(Request $request) {
        $validated = $request->validate([
            'name' => 'required',
        ]);

        $break = GameGroup::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
        ]);

        if($request->input('invitee_list')) {
            $invites = explode(',',$request->input('invitee_list'));
            foreach($invites as $invite) {

                $invite =  strtolower(str_replace(' ','',$invite));
                //Check if invite exists
                $invitee = Invitee::where('email', $invite)->first();
                $break->invitees()->attach($invitee->id);

            }
        }

        $successes = collect(['New Game Group created successfully.']);

        return redirect()->route('breaks');
    }
}
