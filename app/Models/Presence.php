<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Dyrynda\Database\Support\GeneratesUuid;
use Illuminate\Database\Eloquent\SoftDeletes;

class Presence extends Model
{
    use HasFactory;
    use Authorizable;
    use Notifiable;
    use GeneratesUuid;
    use SoftDeletes;

    protected $fillable = [
        'date',
    ];

    protected $hidden = [
        'id',
        'deleted_at'
    ];
}
