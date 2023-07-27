<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\ApiController;
use App\Repositories\Admin\User\DestroyHandling;
use App\Repositories\Admin\User\ListHandling;
use App\Repositories\Admin\User\ListTrashedHandling;
use App\Repositories\Admin\User\RestoreTrashedHandling;
use App\Repositories\Admin\User\ShowHandling;
use App\Repositories\Admin\User\StoreHandling;
use App\Repositories\Admin\User\UpdateHandling;
use Illuminate\Http\Request;

class UserController extends ApiController
{
    /**
     * Pagination list data.
     *
     * @param Illuminate\Http\Request $request
     * @return Illuminate\Http\Response
     */
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

    /**
     * Create new data.
     *
     * @param Illuminate\Http\Request $request
     * @return Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $executor = new StoreHandling($request);
            $data = $executor->handle();

            return $this->responseData($data);
        } catch (\Exception $e) {
            return $this->responseException($e);
        }
    }

    /**
     * Get detail data.
     *
     * @param Illuminate\Http\Request $request
     * @return Illuminate\Http\Response
     */
    // public function show($uuid)
    // {
    //     try {
    //         $executor = new ShowHandling($uuid);
    //         $data = $executor->handle();

    //         return $this->responseData($data);
    //     } catch (\Exception $e) {
    //         return $this->responseException($e);
    //     }
    // }

    /**
     * Update data.
     *
     * @param Illuminate\Http\Request $request
     * @return Illuminate\Http\Response
     */
    // public function update(Request $request, $uuid)
    // {
    //     try {
    //         $executor = new UpdateHandling($request, $uuid);
    //         $data = $executor->handle();

    //         return $this->responseData($data);
    //     } catch (\Exception $e) {
    //         return $this->responseException($e);
    //     }
    // }

    /**
     * Delete data.
     *
     * @param Illuminate\Http\Request $request
     * @return Illuminate\Http\Response
     */
    // public function destroy($uuid)
    // {
    //     try {
    //         $executor = new DestroyHandling($uuid);
    //         $data = $executor->handle();

    //         return $this->responseData($data);
    //     } catch (\Exception $e) {
    //         return $this->responseException($e);
    //     }
    // }

    // TRASH

    /**
     * Pagination list trashed data.
     *
     * @param Illuminate\Http\Request $request
     * @return Illuminate\Http\Response
     */
    // public function listTrashed(Request $request)
    // {
    //     try {
    //         $executor = new ListTrashedHandling($request);
    //         $data = $executor->handle();

    //         return $this->responsePagedList($data);
    //     } catch (\Exception $e) {
    //         return $this->responseException($e);
    //     }
    // }

    // /**
    //  * Restore deleted data.
    //  *
    //  * @param Illuminate\Http\Request $request
    //  * @return Illuminate\Http\Response
    //  */
    // public function restoreTrashed($uuid)
    // {
    //     try {
    //         $executor = new RestoreTrashedHandling($uuid);
    //         $data = $executor->handle();

    //         return $this->responseData($data);
    //     } catch (\Exception $e) {
    //         return $this->responseException($e);
    //     }
    // }
}
