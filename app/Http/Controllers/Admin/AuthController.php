<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\ApiController;
use App\Repositories\Admin\Auth\LoginHandling;
use App\Repositories\Admin\Auth\GetProfileHandling;
use App\Repositories\Admin\Auth\LogoutHandling;
use App\Repositories\Admin\Auth\UpdateProfileHandling;
use App\Repositories\Admin\Auth\UpdateAccountHandling;
use Illuminate\Http\Request;

class AuthController extends ApiController
{

    public function login(Request $request)
    {
        try {
            $executor = new LoginHandling($request);
            $data = $executor->handle();

            return $this->responseData($data);
        } catch (\Exception $e) {
            return $this->responseException($e);
        }
    }

    public function getProfile(Request $request)
    {
        try {
            $executor = new GetProfileHandling($request);
            $data = $executor->handle();

            return $this->responseData($data);
        } catch (\Exception $e) {
            return $this->responseException($e);
        }
    }

    public function logout(Request $request)
    {
        try {
            $executor = new LogoutHandling($request);
            $data = $executor->handle();

            return $this->responseData($data);
        } catch (\Exception $e) {
            return $this->responseException($e);
        }
    }
}
