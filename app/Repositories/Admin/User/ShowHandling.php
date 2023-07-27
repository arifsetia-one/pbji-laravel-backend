<?php

/**
 * @author Arbi Syarifudin <arbisyarifudin@gmail.com>
 */

namespace App\Repositories\Admin\User;

use App\Models\User;
use Illuminate\Support\Facades\DB;

/**
 * Admin > Show User detail.
 */
class ShowHandling
{
    private $uuid;
    private $findData;

    /**
     * Contructor.
     */
    public function __construct(string $uuid)
    {
        $this->uuid = $uuid;
    }

    public function validate()
    {
        // check if user is exists
        $uuid = $this->uuid;
        $this->findData = User::whereUuid($uuid)->first();

        if (!$this->findData) {
            throw new \Exception('User not found!', 404);
        }
    }

    /**
     * Handle request.
     */
    public function handle()
    {
        $this->validate();
        $userId = $this->findData->id;

        $selectedColumns = [
            'users.id',
            'users.uuid',
            'user_personals.fullname',
            'users.uname',
            'users.email',
            'users.email_verified_at',
            'users.is_activated',
            'users.created_at',
            'users.updated_at',
        ];

        $data = User::select($selectedColumns)
            ->join('user_personals', 'user_personals.user_id', '=', 'users.id')
            ->where('users.id', $userId)->first();

        $data->roles = DB::table('roles')
            ->leftJoin('model_has_roles', function ($join) {
                $join->on('roles.id', '=', 'model_has_roles.role_id');
                $join->where('model_has_roles.model_type', '=', 'App\Models\User');
                // })->whereIn('model_has_roles.model_uuid', [$this->findData->uuid])
            })->whereIn('model_has_roles.model_id', [$data->id])
            ->get(['roles.name as name'])->pluck('name');

        $result = $data;
        $result['message'] = 'User detail data';
        return $result;
    }
}
