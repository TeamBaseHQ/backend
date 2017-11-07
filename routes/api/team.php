<?php

Route::group(['prefix' => 'teams', 'namespace' => "Team", 'middleware' => ["auth:api"]], function () {
    Route::post('/', ['as' => "create-team", 'uses' => "CreateTeam"]);
});
