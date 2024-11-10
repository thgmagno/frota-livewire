<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');


Route::group(['middleware' => ['auth']], function () {
    Route::view('group', 'group')
        ->name('group');
});

require __DIR__.'/auth.php';
