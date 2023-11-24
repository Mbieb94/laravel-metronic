<?php

use App\Http\Controllers\AppController;
use App\Http\Controllers\ArtisanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VocabulariesController;
use Illuminate\Support\Facades\Route;

require __DIR__ . '/auth.php';
require __DIR__ . '/api.php';
require __DIR__ . '/pages.php';

Route::get('/', function () {
    if (auth()->user()) return view('dashboard');
    return view('welcome');
});

Route::controller(ArtisanController::class)
    ->prefix('artisan')
    ->name('artisan.')
    ->group(function () {
        Route::get('/storage_link', 'storageLink')->name('storage-link');
        Route::get('/migrate', 'migrateDb')->name('migrate');
        Route::get('/migrate_refresh', 'migrateRefresh')->name('migrate-refresh');
        Route::get('/migrate_fresh', 'migrateFresh')->name('migrate-fresh');
        Route::get('/db_seed', 'dbSeed')->name('db-seed');
        Route::get('/run_schedule', 'runSchedule')->name('run-schedule');
    });

Route::get('lang/{lang}', [LanguageController::class, 'switchLang']);

Route::middleware(['auth', 'verified'])->group(function () {
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/home', 'dashboard')->name('dashboard');
    });
});

Route::middleware(['auth', 'permissions'])->group(function () {
    Route::prefix('vocabularies')->group(function () {
        Route::post('/generate-language', [VocabulariesController::class, 'generateLanguage'])->name('vocabularies.generate-language');
    });

    Route::controller(UserController::class)
        ->prefix('user')
        ->name('user.')
        ->group(function () {
            Route::put('/update_profile', 'postProfile')->name('update_profile');
            Route::get('/', 'list')->name('list');
            Route::get('/create', 'create')->name('create');
            Route::post('/', 'store')->name('create');
            Route::put('/{id}/activation/{status}', 'activation')->name('activation');
            Route::get('/{id}/edit', 'edit')->name('edit');
            Route::put('/{id}', 'update')->name('edit');
            Route::get('/profile', 'profile')->name('profile-detail');
            Route::get('/update_profile', 'updateProfile')->name('update_profile');
            Route::get('/reset_password', 'reset_password')->name('reset_password');
            Route::post('/update_password', 'update_password')->name('reset_password');
        });

    // Roles
    Route::controller(RoleController::class)
        ->prefix('roles')
        ->name('roles.')
        ->group(function () {
            Route::get('/{id}/edit', 'edit')->name('edit');
            Route::put('/{id}', 'update')->name('edit');
            Route::get('/create', 'create')->name('create');
            Route::post('/', 'store')->name('create');
        });

    // If you want to custome, please write above
    Route::controller(AppController::class)
        ->prefix('{collection}')
        ->name(request()->segment(1) . '.')
        ->group(function () {
            Route::get('/', 'list')->name('list');
            Route::post('/', 'store')->name('create');
            Route::get('/export', 'export')->name('export');
            Route::get('/create', 'create')->name('create');
            Route::get('/trashed', 'trashed')->name('trashed');
            Route::get('/{id}', 'detail')->name('detail');
            Route::put('/{id}', 'update')->name('edit');
            Route::post('/{id}', 'delete')->name('delete');
            Route::get('/{id}/edit', 'edit')->name('edit');
            Route::put('/{id}/trash', 'trash')->name('trash');
            Route::put('/{id}/restore', 'restore')->name('restore');
        });
});
