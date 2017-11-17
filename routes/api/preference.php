<?php
Route::group(['middleware' => 'auth:api', 'namespace' => "Preference"], function () {
    Route::get('preferences', ['uses' => "PreferenceController@index"]);
    Route::get('preferences/{name}', ['uses' => "PreferenceController@show"]);
    Route::put('preferences/{name}', ['uses' => "PreferenceController@update"]);
    Route::delete('preferences/{name}', ['uses' => "PreferenceController@destroy"]);
});
