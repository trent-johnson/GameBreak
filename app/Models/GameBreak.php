<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\IcalendarGenerator\Components\Calendar;
use Spatie\IcalendarGenerator\Components\Event;
use DateTime;

class GameBreak extends Model
{
    use HasFactory;

    protected $table = 'break';
    protected $fillable = [
        'event_datetime',
        'location',
        'notes',
        'user_id',
        'vote_timing',
        'rsvp_timing',
        'rsvp_lock',
        'vote_lock',
        'rsvp_control',
        'vote_control',
        'rsvp_limit',
        'vote_limit',
        'remind_rsvp',
        'remind_vote',
        'notify_vote',
        'remind_break',
        'invitee_limit'
    ];

    public function options() {
        return $this->hasMany(Option::class,'break_id');
    }

    public function votes() {
        return $this->hasManyThrough(
            Vote::class,
            Option::class,
            'break_id',
            'option_id',
            'id',
        'id');
    }

    public function invitees() {
        return $this->belongsToMany(
            Invitee::class,
            'break_invite',
            'break_id',
            'invitee_id'
        )->withPivot('status','secure');
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function generateCalendar() {

        return $event = Calendar::create('Game Break')
            ->event(Event::create($this->user->name . "'s Game Break")
                ->startsAt(new DateTime($this->event_datetime))
                ->endsAt(new DateTime(date('Y-m-d H:i:s',strtotime($this->event_datetime . "+2hours"))))
                ->description('Upcoming Game Break session. ' . $this->notes)
                ->address($this->location)
                ->addressName($this->location)
                ->uniqueIdentifier('gamebreak_' . $this->id)
                ->organizer('noreply@gamebreak.app', 'Game Break')
            );

    }
}
