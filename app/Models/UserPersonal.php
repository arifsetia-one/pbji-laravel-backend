<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPersonal extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $hidden = ['user_id', 'created_at', 'updated_at'];

    protected $fillable = [
        'user_id',
        'fullname',
        'place_of_birth',
        'date_of_birth',
        'gender',
        'body_weight',
        'body_height',
        'age',
        'medical_history',
        'injury_history',
        'photo_url',
    ];

    // protected $appends = [
    //     'photo_url'
    // ];

    // Relations

    public function user()
    {
        return $this->belongsTo(User::class, 'user_uuid');
    }

    // Accessors

    public function getGenderLabelAttribute($value)
    {
        $genders = [
            1 => 'Laki-laki',
            2 => 'Perempuan',
        ];

        return $value ? $genders[$value] : null;
    }

}
