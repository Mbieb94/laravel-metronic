<?php

use App\Http\Controllers\Api\ApiGlobalController;
use App\Http\Controllers\Api\ApiMasterAssetController;
use App\Http\Controllers\Api\ApiUserController;
use App\Http\Controllers\Api\AuthControler;
use App\Http\Controllers\Api\ComponentController;
use App\Http\Controllers\Api\RolesController;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::controller(AuthControler::class)->prefix(env('API_VERSION', 'v1'))->group(function () {
    Route::post('/login', 'login')->name('auth.login');
});

Route::get('test_api', function (){
    $data = [
        [
            'title' => 'Test',
            'userId' => 1,
            'username' => 'Anu Gemes',
        ]
    ];

    return response($data);
});


Route::middleware(['auth:sanctum'])->prefix(env('API_VERSION', 'v1'))->group(function () {
    Route::controller(AuthControler::class)->group(function () {
        Route::delete('/logout', 'logout')->name('auth.logout');
    });

    Route::controller(ComponentController::class)->group(function () {
        Route::get('/select2ajax', 'select2')->name('select2.data');
        Route::get('/sysparam', 'sysparam')->name('sysparam.data');
        Route::post('/file_upload', 'file_upload')->name('file.upload');
        Route::post('/delete_file', 'deleteFile')->name('delete.file');
    });

    Route::controller(RolesController::class)->prefix('roles')->name('roles.')->group(function () {
        Route::get('/datatable', 'dataTable')->name('datatable');
    });

    Route::controller(ApiUserController::class)->prefix('user')->name('user.')->group(function () {
        Route::get('/', 'index')->name('list');

        Route::put('/{id}/activation/{status}', 'activation')->name('activation');
        Route::get('/datatable', 'dataTable')->name('datatable');
    });

    Route::controller(ApiMasterAssetController::class)->prefix('master_assets')->name('master_assets.')->group(function () {
        Route::get('/datatable', 'dataTable')->name('datatable');
    });

    Route::controller(ApiGlobalController::class)->prefix('{collection}')->name(request()->segment(3) . '.')->group(function () {
        Route::get('', 'list')->name('list');
        Route::get('/datatable', 'dataTable')->name('datatable');
        Route::post('/{id}', 'delete')->name('delete');
        Route::post('/{id}/trash', 'trash')->name('trash');
        Route::put('/{id}/restore', 'restore')->name('restore');
    });
});
