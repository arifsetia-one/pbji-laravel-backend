<?php

namespace App\Models;

use Dyrynda\Database\Support\GeneratesUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use \Spatie\Permission\Models\Role as SpatieRole;
class Role extends SpatieRole
{
    use HasFactory;
    // use GeneratesUuid;

    // protected $primaryKey = 'id';
    // protected $keyType = 'string'; // id as uuid

    // public function uuidColumn(): string
    // {
    //     return 'id';
    // }

    protected $hidden = [
        'id',
        'pivot',
        'created_at',
        'updated_at',
    ];
}
