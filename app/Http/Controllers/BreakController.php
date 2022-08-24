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
            'break' => GameBreak::make(),
            'successes' => null
        ]);
    }

    public function edit(Request $request, GameBreak $id) {
        return view('break.new', [
            'break' => $id,
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
            'user_id' => auth()->user()->id,
            'rsvp_control' => $request->input('rsvp_control'),
            'rsvp_timing' => $request->input('rsvp_timing'),
            'vote_control' => $request->input('vote_control'),
            'vote_timing' => $request->input('vote_timing'),
            'remind_rsvp' => $request->input('remind_rsvp'),
            'notify_vote' => $request->input('notify_vote'),
            'remind_vote' => $request->input('remind_vote'),
            'remind_break' => $request->input('remind_break')
        ]);

        if($request->input('game_options') && count($request->input('game_options'))) {
            Log::debug('Found game options submitted with new game break');
            foreach($request->input('game_options') as $option) {
                Log::debug('Adding new option: ' . $option);
                Option::create(['bgg_thing_id' => $option, 'break_id' => $break->id]);
            }
        }

        if($request->input('invitee_list')) {
            $invites = explode(',',$request->input('invitee_list'));
            foreach($invites as $invite) {

                $invite =  strtolower(str_replace(' ','',$invite));
                //Check if invite exists
                $invitee = Invitee::where('email', $invite)->first();

                if(!$invitee) {
                    $invitee = Invitee::create(['email' => $invite]);
                }
                $secure = bin2hex(random_bytes(16));
                $break->invitees()->attach($invitee->id, ['secure' => $secure]);

                Mail::to($invite)->queue(new BreakInvite($invitee, $break, $secure));

                Log::debug('New invite for: ' . $invite);
            }
        }

        $successes = collect(['New Game Break scheduled successfully.']);

        return redirect()->route('breaks');
    }
    public function show(Request $request, $id) {
        $break = GameBreak::with(['options','invitees'])->findorfail($id);

        $invitee = null;

        if(!$request->input('invitee_id') && auth()->check()) {
            $invitee = $break->invitees()->where('email',auth()->user()->email)->first();
        } elseif($request->input('invitee_id')) {
            $invitee = $break->invitees()->where([
                ['id',$request->input('invitee_id')],
                ['secure',$request->input('secure')]
            ])->first();
            if(!$invitee) {
                Log::debug('Unable to authenticate guest invitee');
                return redirect()->route('login');
            }
        }
        Log::debug("Invitee located: " . $invitee);
        return view('break.show', [
            'break' => $break,
            'invitee' => $invitee
        ]);
    }
    public function delete(Request $request, $id) {
        GameBreak::find($id)->delete();

        return redirect()->route('breaks');
    }
    public function downloadInvite(Request $request, $id) {

        $break = GameBreak::with('user')->findorfail($id);

        $invitee_id = ($request->input('invitee_id')) ?: null;
        $secure = ($request->input('secure')) ?: null;

        return response($break->generateCalendar($invitee_id, $secure), 200, [
            'Content-Type' => 'text/calendar; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="gamebreak.ics"',
        ]);
    }
}
