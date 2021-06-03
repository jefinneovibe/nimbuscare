<?php

use App\Http\Controllers\WidgetsCreationController;

Route::prefix("test")->group(function() {
    Route::get("create", "WidgetsCreationController@businessDetails");
});