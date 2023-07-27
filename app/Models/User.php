<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Traits\Uuid;
use DateTimeInterface;
use Dyrynda\Database\Support\GeneratesUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Notifications\Notifiable;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
    use Authorizable;
    use HasFactory;

    use GeneratesUuid;
    use HasRoles;
    use SoftDeletes;

    // protected $uuidVersion = 'ordered';

    // protected $primaryKey = 'uuid';
    // protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'uuid',
        'id_number',
        'uname',
        'password',
        'created_by'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'id',
        'password',
        'remember_token',
    ];


    /**
     * Prepare a date for array / JSON serialization.
     *
     * @return string
     */
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }


    // RELATIONS
    public function personal()
    {
        return $this->hasOne(UserPersonal::class);
    }

    public function info()
    {
        return $this->hasOne(UserInfo::class);
    }

    // public function userHasPresence() {
    //     return $this->hasMany(User_has_presence::class);
    // }
    // public function presence() {
    //     return $this->hasMany(Presence::class);
    // }

    public function presence () {
        return $this->belongsToMany(Presence::class, 'user_has_presence', 'user_id_number', 'presence_id');
    }



    // API SESSION (USER)
    /**
     * Logged user profile in current session
     * @var mixed
     */
    static function getProfile()
    {
        $user = auth()->user();
        $roleNames = $user->getRoleNames()->toArray();
        if (in_array('Super Administrator', $roleNames) || in_array('Administrator', $roleNames) || in_array('Atlet', $roleNames) ) {
            $selectedColumns = [
                'users.id',
                'users.uuid',
                'users.id_number',
                'user_personals.fullname',
                'users.uname',
                'users.created_at',
                'users.updated_at',
            ];

            $profile = User::select($selectedColumns)
                ->join('user_personals', 'user_personals.user_id', '=', 'users.id')
                ->where('users.id', $user->id)->first();
        } else {
            $profile = $user;
        }
        $profile->roles = $user->roles;

        return $profile;
    }
}
