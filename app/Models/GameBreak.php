<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
