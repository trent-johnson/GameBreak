<?php

namespace App\Http\Livewire;

use App\Models\GameBreak;
use Asantibanez\LivewireCalendar\LivewireCalendar;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Livewire\Component;
use DateTime;


class GameBreakCalendar extends LivewireCalendar
{
    public function events() : Collection
    {
        return GameBreak::whereDate('event_datetime', '>=', $this->gridStartsAt)
            ->whereDate('event_datetime', '<=', $this->gridEndsAt)
            ->get()
            ->map(function (GameBreak $break) {

                //Check Past Event
                $current = new DateTime();
                $event_date = new DateTime($break->event_datetime);
                $diff = $current > $event_date;

                $game['thumbnail'] = null;

                if($break->vote_lock == 1) {
                    $option = $break->options()->where('winner',1)->first();

                    if($option) {

                        $bgg_game = Cache::remember($option->bgg_thing_id . '_game', 60 * 60 * 24, function () use ($option) {

                            $response = Http::get('https://boardgamegeek.com/xmlapi2/thing?id=' . $option->bgg_thing_id);

                            $xml = simplexml_load_string($response->getBody(), 'SimpleXMLElement', LIBXML_NOCDATA);
                            $json = json_encode($xml);
                            return json_decode($json, true);
                        });
                        $game = $bgg_game['item'];
                    }
                }

                return [
                    'id' => $break->id,
                    'title' => $break->location,
                    'description' => $break->notes,
                    'date' => $break->event_datetime,
                    'past_event' => $diff,
                    'game_thumb' => $game['thumbnail'],
                    'accepted' => $break->invitees()->where('status',1)->count(),
                    'total' => $break->invitees()->count(),
                    'vote_status' => ($break->vote_lock == 1) ? 'Locked' : 'Open',
                    'rsvp_status' => ($break->rsvp_lock == 1) ? 'Locked' : 'Open',
                ];
            });
    }

    public function onEventClick($eventId)
    {
        return redirect()->to('/break/' . $eventId);
    }
}
