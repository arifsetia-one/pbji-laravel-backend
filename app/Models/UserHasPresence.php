<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserHasPresence extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'user_id_number',
        'nama'
    ];
}
