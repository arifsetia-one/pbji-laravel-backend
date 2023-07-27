<?php

namespace App\Repositories\Admin\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginHandling
{
    protected $request;

    function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function validate()
    {
        $rules = [
            'username' => [
                'required',
            ],
            'password' => [
                'required',
            ],
            'remember_me' => [
                'nullable',
                'boolean',
            ]
        ];

        $messages = [
            // 'email.required' => ':attribute is required',
        ];
        $validated = Validator::make($this->request->all(), $rules, $messages)->validate();
        return $validated;
    }

    public function handle()
    {
        $validated = $this->validate();

        $data = [];

        $user = User::where('uname', $validated['username'])
            ->select(['*', 'users.id as id'])
            ->leftJoin('model_has_roles', function ($join) {
                $join->on('users.id', '=', 'model_has_roles.model_id');
                $join->where('model_has_roles.model_type', '=', 'App\Models\User');
            })
            ->leftJoin('roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->whereNull('users.deleted_at')
            ->whereIn('roles.name', ['Super_Administrator', 'Administrator'])
            ->first();

        $checkPassword = $user && !empty($validated['password']) ? Hash::check($validated['password'], $user->password) : false;

        if (!empty($checkPassword)) {
            // $token = Auth::login($user);

            $user = User::whereUuid($user->uuid)->first();

            // if remember_me is true, set ttl to 7 days else set ttl to 12 hour
            $jwtTTl = isset($validated['remember_me']) && $validated['remember_me'] ? 7 * 24 * 60 : 12 * 60;

            \JWTAuth::factory()->setTTL($jwtTTl);
            $token = Auth::login($user);

            $data['token'] = $token;
            $data['type'] = 'bearer';
            $data['expires_in'] = Auth::factory()->getTTL() * 60 * 24; // in minutes
            $data['user'] = auth()->user()->getProfile();
        } else {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'email' => ['Invalid username or password.'],
            ]);
        }

        return $data;
    }
}
