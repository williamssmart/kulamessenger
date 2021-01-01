<?php

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
Route::get('/testing', function (Request $request) {
        return 'it working properly';
    });

Route::group(['middleware' =>'auth:api'], function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::get('view_profile', 'Api\UserController@profile');
    Route::post('send-chat', 'Api\ChatController@store');
    Route::patch('update_profile','Api\UserController@updateProfile');
    Route::post('update_profile_image', 'Api\UserController@updateProfileImages');
    Route::delete('delete-chat/{id}', 'Api\ChatController@destroy');


    Route::get('get-chat', 'Api\ChatController@index');
    Route::get('get-last-chat', 'Api\ChatController@getLastChat');
    Route::get('get-chat-from-lastseen/{last_seen_id}', 'Api\ChatController@getChatBasedOnLastSeen');
    Route::post('send-chat-from-blog', 'Api\ChatController@saveBlogChat');
});


 Route::post('/register', 'Api\AuthController@register');
 Route::post('/login', 'Api\AuthController@login');

 Route::get('get-compounds', 'Api\UserController@getCompounds');



// Route::post('/register', 'App\Http\Controllers\Api\AuthController@register');
// Route::post('/login', 'App\Http\Controllers\Api\AuthController@login');
