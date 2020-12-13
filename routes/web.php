<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');
Route::view('/statistic', 'statistic');
Route::view('/add-girl', 'add_girl');

Route::get('/add-users', [App\Http\Controllers\ScreensController::class, 'addUsers']);
Route::get('/get-random-image', [App\Http\Controllers\ScreensController::class, 'getRandomImage']);
Route::get('/convert-cyrillic', [App\Http\Controllers\ScreensController::class, 'convertCyrillicToLatin']);

Route::post('/get-next-screen', [App\Http\Controllers\ScreensController::class, 'getScreens']);
Route::post('/delete-id', [App\Http\Controllers\ScreensController::class, 'deleteId']);
Route::post('/like-id', [App\Http\Controllers\ScreensController::class, 'likeId']);
Route::post('/zero-views-clicks', [App\Http\Controllers\ScreensController::class, 'zeroViewsClicks']);
Route::post('/add-girl', [App\Http\Controllers\ScreensController::class, 'addGirl']);
Route::post('/increase-view-id', [App\Http\Controllers\ScreensController::class, 'increaseViews']);
