<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ModeratorController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('user')->controller(UserController::class)->group(function () {

    Route::post('/register', 'register')->name('user.register');
    Route::post('/login', 'login')->name('user.login');

    Route::group(['middleware' => 'auth:sanctum'], function () {
       Route::get('/logout', 'logout')->name('user.logout');
       Route::post('/change', 'changePassword')->name('user.change');
    });
});


Route::prefix('admin')->controller(AdminController::class)->group(function () {

    Route::post('/register', 'register')->name('admin.register');
    Route::post('/login', 'login')->name('admin.login');

    Route::group(['middleware' => 'auth:sanctum'], function () {
       Route::get('/logout', 'logout')->name('admin.logout');
       Route::post('/change', 'changePassword')->name('admin.change');
    });
});

Route::prefix('moderator')->controller(ModeratorController::class)->group(function () {

    Route::post('/register', 'register')->name('moderator.register');
    Route::post('/login', 'login')->name('moderator.login');

    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::get('/logout', 'logout')->name('moderator.logout');
        Route::post('/change', 'changePassword')->name('moderator.change');
    });
});
