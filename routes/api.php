<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('menus')->name('menus.')->controller(MenuController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/', 'store')->name('store');
    Route::get('/{menu}', 'show')->name('show');
    Route::put('/{menu}', 'update')->name('update');
    Route::delete('/{menu}', 'destroy')->name('destroy');
});
