
<?php

/**
 * @author Arbi Syarifudin <arbisyarifudin@gmail.com>
 */

namespace App\Repositories\Admin\User;

use App\Models\User;
use App\Models\UserPersonal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\Role;

/**
 * Admin > Update User data.
 */
class UpdateHandling
{
    private $request;
    private $uuid;
    private $findData;

    /**
     * Contructor.
     */
    public function __construct(Request $request, $uuid)
    {
        $this->request = $request;
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

        $roleNames = ['Administrator', 'Manajer', 'Moderator', 'Editor', 'Member', 'Contributor'];

        $rules = [
            'fullname' => [
                'required',
                'string',
            ],
            'uname' => [
                'nullable',
                'string',
                Rule::unique(User::class, 'uname')->ignore($this->findData->id, 'id'),
            ],
            'email' => [
                'nullable',
                'string',
                Rule::unique(User::class, 'email')->ignore($this->findData->id, 'id'),
            ],
            'is_activated' => [
                'nullable',
                'boolean',
            ],
            'password' => [
                'nullable',
                'string',
                'min:6'
            ],
            'photo_url' => [
                'nullable',
                'string',
                'url',
            ],
            'roles' => [
                'nullable',
                'array',
            ],
            'roles.*' => [
                'sometimes',
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

            $userUpdatableFields = ['uname', 'email', 'password', 'is_activated'];
            $user = $this->findData;
            foreach ($userUpdatableFields as $fieldName) {
                if (isset($validated[$fieldName])) {
                    if ($fieldName === 'password') {
                        $user->$fieldName = Hash::make($validated[$fieldName]);
                    } else {
                        $user->$fieldName = $validated[$fieldName];
                    }
                }
            }
            $user->save();

            if(isset($validated['photo_url'])) {
                $validated['photo'] = $validated['photo_url'];
                unset($validated['photo_url']);
            }

            $userPersonalUpdatableFields = ['fullname', 'photo'];
            // $userPersonal = UserPersonal::where('user_uuid', $user->uuid)->first();
            // $userPersonal = UserPersonal::where('user_id', $user->id)->first();
            $userPersonalUpdatedFields = [];
            foreach ($userPersonalUpdatableFields as $fieldName) {
                if (isset($validated[$fieldName])) {
                    // $userPersonal->$fieldName = $validated[$fieldName];
                    $userPersonalUpdatedFields[$fieldName] = $validated[$fieldName];
                }
            }
            $userPersonal = UserPersonal::where('user_id', $user->id)->update($userPersonalUpdatedFields);
            $user->fullname = $userPersonalUpdatedFields['fullname'];

            // assign role
            if (!empty(@$validated['roles'])) {
                // get current user role & remove
                $currentRoles = $user->getRoleNames();
                foreach ($currentRoles as $key => $currentRole) {
                    $user->removeRole($currentRole);
                }
                // reassigne role to user
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
        $result['message'] = 'User updated successfully!';
        return $result;
    }
}
