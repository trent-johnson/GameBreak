<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\IcalendarGenerator\Components\Calendar;
use Spatie\IcalendarGenerator\Components\Event;
use DateTime;
use Spatie\CalendarLinks\Link;

class GameBreak extends Model
{
    use HasFactory;
    use SoftDeletes;

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

    public function generateCalendar($invitee_id = null, $secure = null) {

        $url = url('/') . '/break/' . $this->id;

        if($invitee_id) {
            $url .= '?invitee_id=' . $invitee_id . '&secure=' . $secure;
        }

        $event = Link::create($this->user->name . "'s Game Break",
            new DateTime($this->event_datetime),
            new DateTime(date('Y-m-d H:i:s',strtotime($this->event_datetime . "+2hours"))))
                ->description('Upcoming Game Break session.\n\nView Details: ' . $url . '\n\n' . $this->notes)
                ->address($this->location);

        return str_replace(
            ';TZID=America/New_York',
            '',
                   str_replace(
                'X-ALT-DESC',
                'DESCRIPTION',
                    (
                        base64_decode(
                        str_replace(
                            'data:text/calendar;charset=utf8;base64,',
                            '',
                            $event->ics(['UID' => md5($this->id . '_gamebreak_' . $this->user->name)])
                        )
                    )
                )
           )
        );

    }
}
