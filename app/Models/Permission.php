<?php

namespace App\Models;

use Dyrynda\Database\Support\GeneratesUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use \Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    use HasFactory;
    use GeneratesUuid;

    protected $primaryKey = 'id';
    protected $keyType = 'string'; // id as uuid

    public function uuidColumn(): string
    {
        return 'id';
    }
}
