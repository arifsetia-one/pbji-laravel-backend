<?php

namespace App\Http\Controllers\Atlet;

use App\Http\Controllers\ApiController;
use App\Repositories\Atlet\Auth\RegisterHandling;
use App\Repositories\Atlet\Auth\LoginHandling;
use App\Repositories\Atlet\Auth\GetProfileHandling;
use App\Repositories\Atlet\Auth\LogoutHandling;
use App\Repositories\Atlet\Auth\GetPresenceCountHandling;
use Illuminate\Http\Request;

class AuthController extends ApiController
{

    public function register(Request $request)
    {
        try {
            $executor = new RegisterHandling($request);
            $data = $executor->handle();

            return $this->responseData($data);
        } catch (\Exception $e) {
            return $this->responseException($e);
        }
    }

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

    public function getCount(Request $request)
    {
        try {
            $executor = new GetPresenceCountHandling($request);
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
