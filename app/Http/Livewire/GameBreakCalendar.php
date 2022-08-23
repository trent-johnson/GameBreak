<?php

namespace App\Http\Livewire;

use App\Models\GameBreak;
use Asantibanez\LivewireCalendar\LivewireCalendar;
use Illuminate\Support\Collection;
use Livewire\Component;

class GameBreakCalendar extends LivewireCalendar
{
    public function events() : Collection
    {
        return GameBreak::whereDate('event_datetime', '>=', $this->gridStartsAt)
            ->whereDate('event_datetime', '<=', $this->gridEndsAt)
            ->get()
            ->map(function (GameBreak $break) {
                return [
                    'id' => $break->id,
                    'title' => $break->location,
                    'description' => $break->notes,
                    'date' => $break->event_datetime,
                ];
            });
    }

    public function onEventClick($eventId)
    {
        return redirect()->to('/break/' . $eventId);
    }
}
