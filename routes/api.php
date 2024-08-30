<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;


Route::prefix('menus')->name('menus.')->controller(MenuController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/create', 'create')->name('create');
    Route::post('/', 'store')->name('store');
    Route::get('/{menu}', 'show')->name('show');
    Route::get('/{menu}/edit', 'edit')->name('edit');
    Route::put('/{menu}', 'update')->name('update');
    Route::delete('/{menu}', 'destroy')->name('destroy');
});
