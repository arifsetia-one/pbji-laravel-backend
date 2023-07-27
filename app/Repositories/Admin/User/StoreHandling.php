<?php

/**
 * @author Arbi Syarifudin <arbisyarifudin@gmail.com>
 */

namespace App\Repositories\Admin\User;

use App\Models\User;
use App\Models\UserPersonal;
use App\Models\UserInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\Role;
use Illuminate\Support\Str;

/**
 * Admin > Add new User data.
 */
class StoreHandling
{
    private $request;

    /**
     * Contructor.
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function validate()
    {
        $roleNames = ['SuperAdministrator', 'Administrator', 'Atlet'];

        $rules = [
            'fullname' => [
                'required',
                'string',
            ],
            'username' => [
                'required',
                'string',
                Rule::unique(User::class, 'uname')
            ],
            'id_number' => [
                'required',
                'integer',
            ],
            'password' => [
                'required',
                'string',
                'min:6'
            ],
            'full_addresses' => [
                'nullable',
                'string',
            ],
            'roles' => [
                'required',
                'array',
            ],
            'roles.*' => [
                'required',
                'string',
                Rule::in($roleNames)
            ],
        ];

        $messages = [];

        $validated = Validator::make($this->request->all(), $rules, $messages)->validate();

        return $validated;
    }

    /**
     * Handle request.
     */
    public function handle()
    {
        $validated = $this->validate();

        DB::beginTransaction();
        try {

            // for mysql
            $userUuid = \Uuid::uuid4()->toString();
            $info = Str::uuid()->toString();

            $user = User::create([
                'uuid' => $userUuid, // postgre doesnt need it
                'uname' => $validated['username'],
                'id_number' => $validated['id_number'],
                'password' => Hash::make($validated['password']),
            ]);

            UserPersonal::create([
                // 'user_uuid' => $user->uuid, // for postgre
                // 'user_uuid' => $userUuid, // for mysql
                'user_id' => $user->id, // for mysql
                'fullname' => $validated['fullname'],
                // 'photo_url' => @$validated['photo_url'],
                // 'photo' => @$validated['photo_url'],
            ]);

            UserInfo::create([
                'user_id'=> $user->id,
                'full_addresses' => $validated['full_addresses']
            ]);
            // dd($userInfo);
            // die();



            // assign role
            if (!empty(@$validated['roles'])) {
                foreach ($validated['roles'] as $key => $roleName) {
                    $userRole = Role::findOrCreate($roleName, 'api');
                    $user->assignRole($userRole);
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        $result = $user;
        $result['message'] = 'User created successfully!';
        return $result;
    }
}
