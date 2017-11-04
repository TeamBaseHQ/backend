<?php

Route::group(['prefix' => 'users', 'namespace' => "User"], function () {
    Route::post('/', ['as' => "create-user", 'uses' => "CreateUser"]);
    Route::post('login', ['as' => 'login', 'uses' => "LoginController@login"]);
    Route::post('login/refresh', ['as' => 'login-refresh', 'uses' => "LoginController@refresh"]);

    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('/{id}', ['as' => "show-user", 'uses' => "ShowUser"]);
    });

});
