<?php

use Illuminate\Http\Request;
use Base\Http\Resources\BaseAPI;

Route::get('/', function () {
    return new BaseAPI();
});

Route::group(['prefix' => 'users'], function () {
    Route::post('login', ['as' => 'login', 'uses' => "LoginController@login"]);
});

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});
