<?php

use Illuminate\Support\Facades\Route;
use Vector\Spider\Http\Controllers\AdminControllers\AdminPageController;
use Vector\Spider\Http\Controllers\AdminControllers\EmployeeController;
use Vector\Spider\Http\Controllers\AdminControllers\SEOController;
use Vector\Spider\Http\Middleware\AdminAuthMiddleware;

Route::get('', fn () => view('Spider::admin.index'))->name('admin_home');
Route::get('index', fn () => redirect()->route('admin_home'));

Route::controller(AdminPageController::class)->prefix('page')->group(function () {
    Route::get('', 'ui_view_pages');
    Route::prefix('create')->group(function () {
        Route::get('', 'ui_modify_page');
        Route::post('', 'web_modify_page');
    });
    Route::prefix("group")->group(function () {
        Route::get('', 'ui_view_groups');
        Route::prefix("create")->group(function () {
            Route::get('', 'ui_modify_group');
            Route::post('', 'web_modify_group');
        });
        Route::prefix('{groupId}')->group(function () {
            Route::get('', 'ui_view_group');
            Route::prefix("update")->group(function () {
                Route::get('', 'ui_modify_group');
                Route::post('', 'web_modify_group');
            });
        });
    });
    Route::prefix('{pageId}')->group(function () {
        Route::get('', 'ui_view_page');
        Route::prefix('update')->group(function () {
            Route::get('', 'ui_modify_page');
            Route::post('', 'web_modify_page');
        });
    })->whereNumber('pageId');
});

Route::controller(EmployeeController::class)->group(function () {
    Route::withoutMiddleware(AdminAuthMiddleware::class)->group(function () {
        Route::prefix('login')->group(function () {
            Route::get('', 'ui_login')->name('admin_login');
            Route::post('', 'web_login');
        });
        Route::any('logout', 'web_logout')->name('admin_logout');
    });

    Route::prefix('employee')->group(function () {
        Route::get('', 'ui_view_emps');
        Route::prefix('create')->group(function () {
            Route::get('', 'ui_modify_emp');
            Route::post('', 'web_modify_emp');
        });
        Route::prefix('{empId}')->group(function () {
            Route::get('', 'ui_view_emp');
            Route::prefix('update')->group(function () {
                Route::get('', 'ui_modify_emp');
                Route::post('', 'web_modify_emp');
            });
        })->whereNumber('empId');
    });

    Route::prefix('jobrole')->group(function () {
        Route::get('', 'ui_view_roles');
        Route::prefix('create')->group(function () {
            Route::get('', 'ui_modify_role');
            Route::post('', 'web_modify_role');
        });
        Route::prefix('{roleId}')->group(function () {
            Route::get('', 'ui_view_role');
            Route::prefix('update')->group(function () {
                Route::get('', 'ui_modify_role');
                Route::post('', 'web_modify_role');
            });
        })->whereNumber('roleId');
    });
});

Route::controller(SEOController::class)->group(function () {
    Route::prefix('webpage')->group(function () {
        Route::get('', 'ui_view_webpages');
        Route::prefix('create')->group(function () {
            Route::get('', 'ui_modify_webpage');
            Route::post('', 'web_modify_webpage');
        });
        Route::prefix('{webPageId}')->group(function () {
            Route::get('', 'ui_view_webpage');
            Route::prefix('update')->group(function () {
                Route::get('', 'ui_modify_webpage');
                Route::post('', 'web_modify_webpage');
            });
        })->whereNumber('webPageId');
    });
    Route::prefix('webimage')->group(function () {
        Route::get('', 'ui_view_webimages');
        Route::prefix('upload')->group(function () {
            Route::get('', 'ui_modify_webimage');
            Route::post('', 'web_modify_webimage');
        });
        Route::prefix('{webImageId}')->group(function () {
            Route::get('', 'ui_view_webimage');
            Route::prefix('update')->group(function () {
                Route::get('', 'ui_modify_webimage');
                Route::post('', 'web_modify_webimage');
            });
        })->whereNumber('webImageId');
    });
});
