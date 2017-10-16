<?php

use Illuminate\Http\Request;
use App\Http\Resources\BaseAPI;

Route::get('/', function () {
    return new BaseAPI();
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
