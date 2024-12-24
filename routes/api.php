<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
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
       Route::post('editProfile', 'editProfile')->name('user.editProfile');
    });
});


Route::prefix('admin')->controller(AdminController::class)->group(function () {

    Route::post('/login', 'login')->name('admin.login');

    Route::group(['middleware' => 'auth:sanctum'], function () {
       Route::get('/logout', 'logout')->name('admin.logout');
       Route::post('/change', 'changePassword')->name('admin.change');
       Route::post('addModerator', 'addModerator')->name('admin.addModerator');
       Route::post('editProfile', 'editProfile')->name('admin.editProfile');
    });
});

Route::prefix('moderator')->controller(ModeratorController::class)->group(function () {

    Route::post('/login', 'login')->name('moderator.login');

    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::get('/logout', 'logout')->name('moderator.logout');
        Route::post('/change', 'changePassword')->name('moderator.change');
        Route::post('editProfile', 'editProfile')->name('moderator.editProfile');
    });
});

Route::prefix('categories')->controller(CategoryController::class)->group(function () {
    Route::get('/', 'get')->name('categories.get');
    Route::post('/', 'create')->name('categories.create');
    Route::post('/{id}', 'update')->name('categories.update');
    Route::delete('/{id}', 'delete')->name('categories.delete');
    Route::get('/{id}', 'getById')->name('categories.getById');
    Route::get('details/{id}', 'getDetails')->name('categories.getDetails');
    Route::get('/sub/{id}', 'getSubCategories')->name('categories.getSubCategories');
    Route::get('/all', 'getAll')->name('categories.getAll');
});

