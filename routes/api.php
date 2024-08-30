<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;


Route::prefix('api')->name('menus.')->controller(MenuController::class)->group(function () {
    Route::get('/menus', 'index')->name('index');
    Route::post('/menus', 'store')->name('store');
    Route::get('/menus/{menu}', 'show')->name('show');
    Route::put('/menus/{menu}', 'update')->name('update');
    Route::delete('/menus/{menu}', 'destroy')->name('destroy');
});
