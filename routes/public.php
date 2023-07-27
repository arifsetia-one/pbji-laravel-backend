<?php

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Atlet\AuthController as AtletAuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return response()->json([
        'status' => 'OK',
        'status_code' => 200,
        'framework' => 'Laravel v9.0',
    ]);
});

// API VERSION 1
Route::group(['prefix' => 'v1'], function ($routes) {

    /* ADMIN */
    Route::group(
        ['prefix' => 'admin'],
        function ($routes) {
            Route::group(
                ['prefix' => 'auth'],
                function ($routes) {
                        $routes->post('login', [AdminAuthController::class, 'login']);
                    }
            );
        }
    );

    /* ATLET */
    Route::group(
        ['prefix' => 'atlet'],
        function ($routes) {
            Route::group(
                ['prefix' => 'auth'],
                function ($routes) {
                        $routes->post('register', [AtletAuthController::class, 'register']);
                        $routes->post('login', [AtletAuthController::class, 'login']);
                    }
            );
        }
    );
});
