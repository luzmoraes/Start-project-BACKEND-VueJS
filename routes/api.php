<?php

use Illuminate\Http\Request;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group([
    'middleware' => 'auth:api',
    'namespace' => 'Api\\'
], function () {

    // Route::get('auth/me', 'AuthController@me');

    Route::name('user::')->prefix('user')->group(function () {
        Route::get('me', 'UserController@getUser');
        Route::get('list', 'UserController@getAllUsers');
        Route::get('logout', 'UserController@logout');
    });

});
