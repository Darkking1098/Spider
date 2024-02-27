<?php

use Illuminate\Support\Facades\Route;
use Vector\Spider\Http\Controllers\AdminControllers\AdminPageController;

Route::controller(AdminPageController::class)->prefix('page')->group(function () {
    Route::prefix("group")->group(function () {
        Route::prefix('{groupId}')->group(function () {
            Route::get('toggle', 'api_toggle_group_status');
            Route::get('delete', 'api_delete_group');
        })->whereNumber('groupId');
    });
    Route::prefix('{pageId}')->group(function () {
        Route::get('toggle', 'api_toggle_page_status');
        Route::get('delete', 'api_delete_page');
    })->whereNumber('pageId');
});
