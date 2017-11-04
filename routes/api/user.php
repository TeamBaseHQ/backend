<?php

Route::group(['prefix' => 'users'], function () {
    Route::post('login', ['as' => 'login', 'uses' => "LoginController@login"]);
    Route::post('login/refresh', ['as' => 'login-refresh', 'uses' => "LoginController@refresh"]);

    Route::group(['middleware' => 'auth:api', 'namespace' => "User"], function () {
        Route::get('/{id}', ['as' => "show-user", 'uses' => "ShowUser"]);
        Route::post('/', ['as' => "create-user", 'uses' => "CreateUser"]);
    });

});
