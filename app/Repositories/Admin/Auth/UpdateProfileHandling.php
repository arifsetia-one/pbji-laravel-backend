<?php

namespace App\Repositories\Admin\Auth;

// use App\Models\User;
use App\Models\UserPersonal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UpdateProfileHandling
{
    private $request;
    // private $findData;

    /*
        Constructor
    */

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function validate()
    {

        $genderLabel = config('enums.gender');
        $genderNumber = array_keys($genderLabel);

        $rules = [
            'fullname' => [
                'required',
                'string'
            ],
            'place_of_birth' => [
                'nullable',
                'string'
            ],
            'date_of_birth' => [
                'nullable',
                'date'
            ],
            'gender' => [
                'nullable',
                Rule::in($genderNumber)
            ]
        ];

        $messages = [
            'gender.in' => 'Only Allowed: ' . implode(', ', $genderLabel),
        ];
        // dd($this->request->all());

        $validated = Validator::make($this->request->all(), $rules, $messages)->validate();
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
            $profileUpdatableField = ['fullname', 'place_of_birth', 'date_of_birth', 'gender'];
            // dd($user);
            // die;

            // $userProfile = UserPersonal::where('user_id', $user->id)->first();
            $updateData = [];
            foreach ($profileUpdatableField as $fieldName) {
                if (isset($validated[$fieldName])) {
                    // $userProfile->$fieldName = $validated[$fieldName];
                    $updateData[$fieldName] = $validated[$fieldName];
                }
            }
            // $userProfile->save();
            UserPersonal::where('user_id', $user->id)->update($updateData);

            // dd($userProfile);
            // die;

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        $result = auth()->user()->getProfile();
        $result['message'] = 'User profile updated successfully';
        return $result;
    }
}
