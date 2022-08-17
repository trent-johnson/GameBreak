<?php

namespace App\Http\Controllers;

use App\Mail\BreakInvite;
use App\Models\GameBreak;
use App\Models\Option;
use App\Models\Invitee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class BreakController extends Controller
{
    public function index() {
        $breaks = GameBreak::where('user_id', auth()->user()->id)->get();
        return view('break.index', [
            'breaks' => $breaks
        ]);
    }
    public function create() {
        return view('break.new', [
            'successes' => null
        ]);
    }
    public function save(Request $request) {
        $validated = $request->validate([
            'event_datetime' => 'required',
            'location' => 'required'
        ]);

        $break = GameBreak::create([
            'event_datetime' => $request->input('event_datetime'),
            'location' => $request->input('location'),
            'notes' => $request->input('notes'),
            'user_id' => auth()->user()->id
        ]);

        if(count($request->input('game_options'))) {
            Log::debug('Found game options submitted with new game break');
            foreach($request->input('game_options') as $option) {
                Log::debug('Adding new option: ' . $option);
                Option::create(['bgg_thing_id' => $option, 'break_id' => $break->id]);
            }
        }

        if($request->input('invitee_list')) {
            $invites = explode(',',$request->input('invitee_list'));
            foreach($invites as $invite) {
                $invite = str_replace(' ','',$invite);
                $invitee = Invitee::create(['email' => $invite]);
                $secure = bin2hex(random_bytes(16));

                $break->invitees()->attach($invitee->id, ['secure' => $secure]);

                Mail::to($invite)->send(new BreakInvite($invitee, $break, $secure));

                Log::debug('New invite for: ' . $invite);
            }
        }

        $successes = collect(['New Game Break scheduled successfully.']);

        return redirect()->route('breaks');
    }

    public function show(Request $request, $id) {
        $break = GameBreak::with(['options','invitees'])->findorfail($id);

        $invitee = null;

        if(!$request->input('invitee_id')) {
            $invitee = $break->invitees()->where('email',auth()->user()->email)->first();
        } else {
            $invitee = $break->invitees()->find($request->input('invitee_id'));
        }
        Log::debug("Invitee located: " . $invitee);
        return view('break.show', [
            'break' => $break,
            'invitee' => $invitee
        ]);
    }
}
