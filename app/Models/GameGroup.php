<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameGroup extends Model
{
    use HasFactory;

    protected $table = 'game_group';
    protected $fillable = [
        'name',
        'description'
    ];

    public function invitees() {
        return $this->belongsToMany(
            Invitee::class,
            'group_invite',
            'group_id',
            'invitee_id'
        );
    }
}
