<?php

use Base\Helpers;
use Base\Http\Resources\BaseAPI;

Route::get('/', function () {
    return new BaseAPI();
});

// API Routes
Helpers::requireAllFilesInDirectory(__DIR__ . "/api");
