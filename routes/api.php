<?php

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


