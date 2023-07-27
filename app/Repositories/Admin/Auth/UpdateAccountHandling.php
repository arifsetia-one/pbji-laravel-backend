<?php

namespace App\Repositories\Admin\Auth;

use App\Models\User;
use App\Models\UserPersonal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UpdateAccountHandling
{

    private $request;

    /*
        Constructor
    */

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function validate()
    {
        $userLogin = auth()->user();

        $rules = [
            'uname' => [
                'nullable',
                'string',
                Rule::unique(User::class, 'uname')->ignore($userLogin->id)
            ],
            'email' => [
                'nullable',
                'string',
                Rule::unique(User::class, 'email')->ignore($userLogin->id)
            ],
            'pnumber' => [
                'nullable',
                'string',
            ],
            'old_password' => [
                'nullable',
                'string',
                Rule::requiredIf(function () {
                    return $this->request->has('new_password') && !empty($this->request->new_password);
                })
            ],
            'new_password' => [
                'nullable',
                'string',
                'min:8'
            ],
            'new_password_confirmation' => [
                'nullable',
                'string',
                'min:8',
                Rule::requiredIf(function () {
                    return $this->request->has('new_password') && !empty($this->request->new_password);
                }),
                'same:new_password'
            ]
        ];

        $messages = [];
        // dd($this->request->all());

        $validated = Validator::make($this->request->all(), $rules, $messages)->validate();

        // echo $validated['old_password'] . PHP_EOL;
        // echo $userLogin->password . PHP_EOL;


        // verifikasi password lama jika ada perubahan password
        if ($this->request->has('new_password') && !empty($this->request->new_password)) {
            // cek password lama dengan password user yang ada di database
            if (Hash::check($this->request->old_password, $userLogin->password) !== true) {
                throw new \Exception('Old password is not valid!', 400);
            }
        }


        return $validated;
    }

    public function handle()
    {
        $validated = $this->validate();

        // dd($validated);
        // die;

        DB::beginTransaction();

        try {
            $user = auth()->user();
            // dd($user);
            // die;
            $accountUpdatableFields = ['uname', 'email'];

            $updateAccount = [];
            foreach ($accountUpdatableFields as $fieldName) {
                if (isset($validated[$fieldName])) {
                    $user->$fieldName = $validated[$fieldName];
                    // $updateAccount[$fieldName] = $validated[$fieldName];
                }
            }

            // update password jika ada perubahan
            if ($this->request->has('new_password') && !empty($this->request->new_password)) {
                $user->password = Hash::make($this->request->new_password);
            }

            $user->save();
            // User::find($user->id)->update($updateAccount);


            $profileUpdatableField = ['pnumber'];
            $updateProfile = [];
            foreach ($profileUpdatableField as $fieldName) {
                if (isset($validated[$fieldName])) {
                    $updateProfile[$fieldName] = $validated[$fieldName];
                }
            }
            UserPersonal::where('user_id', $user->id)->update($updateProfile);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }


        $result = $user;
        $result['message'] = 'User updated successfully !';
        return $result;
    }
}
