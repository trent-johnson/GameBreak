<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    use HasFactory;
    protected $table ='options';
    protected $fillable = [
        'bgg_thing_id',
        'break_id',
        'winner'
    ];

    public function votes() {
        return $this->hasMany(Vote::class);
    }

    public function break() {
        return $this->belongsTo(GameBreak::class);
    }
}
