<?php

Route::group(['prefix' => 'admin', 'namespace' => "Admin", 'middleware' => ["auth:api"]], function () {
    Route::group(['namespace' => "Preference"], function () {
        Route::apiResource("preference-categories", "PreferenceCategoryController");
    });
});
