<?php

use App\Http\Controllers\Web\WebController;
use Illuminate\Support\Facades\Route;

Route::controller(WebController::class)
    ->group(function(){
        Route::get('/home-page', 'index')->name('Home Page');
    });