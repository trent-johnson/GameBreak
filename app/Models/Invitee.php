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
}
