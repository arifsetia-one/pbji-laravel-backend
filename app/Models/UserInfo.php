<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    use HasFactory;

    // protected $guarded = [];
    public $incrementing = false;
    protected $hidden = ['user_id', 'created_at', 'updated_at'];

    protected $fillable = [
        'user_id',
        'postal_code',
        'village_name',
        'sub_district',
        'city_name',
        'province',
        'full_addresses',
        'phone_number',
        'whatsapp_number'
    ];

    // Relations

    public function user()
    {
        return $this->belongsTo(User::class, 'user_uuid');
    }
}
