<?php

/* ADMIN */

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\PresenceController as AdminPresenceController;

/* MEMBER */
use App\Http\Controllers\Atlet\AuthController as AtletAuthController;

/*  */
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


// API VERSION 1
Route::group(['prefix' => 'v1', 'middleware' => 'auth:api'], function ($routes) {
    /* ADMIN */
    Route::group(
        ['prefix' => 'admin', 'middleware' => ['role:Super_Administrator']],
        function ($routes) {

            /* ADMIN > AUTH */
            Route::group(
                ['prefix' => 'auth'],
                function ($routes) {
                    $routes->get('profile', [AdminAuthController::class, 'getProfile']);
                    $routes->post('logout', [AdminAuthController::class, 'logout']);
                    $routes->put('update-profile', [AdminAuthController::class, 'updateProfile']);
                    $routes->put('update-account', [AdminAuthController::class, 'updateAccount']);
                }
            );

            /* ADMIN > USER */
            Route::group(
                ['prefix' => 'user'],
                function ($routes) {
                    $routes->get('', [AdminUserController::class, 'list']);
                    $routes->get('trashed', [AdminUserController::class, 'listTrashed']);
                    $routes->get('{uuid}', [AdminUserController::class, 'show']);
                    $routes->post('', [AdminUserController::class, 'store']);
                    $routes->delete('{uuid}', [AdminUserController::class, 'destroy']);
                    $routes->put('{uuid}', [AdminUserController::class, 'update']);
                    $routes->put('{uuid}/restore', [AdminUserController::class, 'restoreTrashed']);
                }
            );

             /* ATLET > PRESENCE */
             Route::group(
                ['prefix' => 'atlet'],
                function ($routes) {
                    $routes->get('', [AdminPresenceController::class, 'list']);
                    $routes->post('/presence', [AdminPresenceController::class, 'presenceHandling']);
                    // $routes->post('/addPresence', [AdminPresenceController::class, 'store']);
                }
            );


        }
    );

    /* MEMBER */
    Route::group(
        ['prefix' => 'atlet', 'middleware' => ['role:Atlet']],
        function ($routes) {
            Route::group(
                ['prefix' => 'auth'],
                function ($routes) {
                    $routes->get('profile', [AtletAuthController::class, 'getProfile']);
                    $routes->get('presence-count', [AtletAuthController::class, 'getCount']);
                    $routes->post('logout', [AdminAuthController::class, 'logout']);
                }
            );

           
        }
    );
});
