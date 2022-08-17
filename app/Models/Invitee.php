<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invitee extends Model
{
    use HasFactory;
    protected $table = 'invitee';

    protected $fillable = [
        'email'
    ];

    public function breaks() {
        return $this->belongsToMany(
            GameBreak::class,
            'break_invite',
            'invitee_id',
            'break_id'
        )->withPivot('status','secure');
    }
}
