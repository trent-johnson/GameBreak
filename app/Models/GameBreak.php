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
        'user_id'
    ];

    public function options() {
        return $this->hasMany(Option::class,'break_id');
    }

    public function invitees() {
        return $this->belongsToMany(
            Invitee::class,
            'break_invite',
            'break_id',
            'invitee_id'
        );
    }
}
