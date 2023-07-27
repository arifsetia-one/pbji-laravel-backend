<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\ApiController;
use App\Repositories\Admin\Presence\StoreHandling;
use App\Repositories\Admin\Presence\PresenceHandling;
use App\Repositories\Admin\Presence\ListHandling;
use Illuminate\Http\Request;


class PresenceController extends ApiController
{


    public function list(Request $request)
    {
        try {
            $executor = new ListHandling($request);
            $data = $executor->handle();

            return $this->responsePagedList($data);
        } catch (\Exception $e) {
            return $this->responseException($e);
        }
    }


    // // store 'add presence'

    // public function store(Request $request) {
    //     try {
    //         $executor = new StoreHandling($request);
    //         $data = $executor->handle();

    //         return $this->responseData($data);
    //     } catch (\Exception $e) {
    //         return $this->responseException($e);
    //     }
    // }



    public function presenceHandling(Request $request) {
        try {
            $executor = new PresenceHandling($request);
            $data = $executor->handle();

            return $this->responseData($data);
        } catch (\Exception $e) {
            return $this->responseException($e);
        }
    }

    
}
