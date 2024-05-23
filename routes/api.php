<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SizeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/user', function (Request $request) {
    return "test";
})->middleware('auth:api');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:api')->post('/logout', [AuthController::class, 'logout']);
Route::post('/requestValidationKey', [AuthController::class, 'requestValidationKey']);
Route::post('/resetPassword', [AuthController::class, 'resetPassword']);
Route::middleware('auth:api')->post('/refresh', [AuthController::class, 'refresh']);
Route::post('/changePassword', [AuthController::class, 'changePassword']);


//test za prijavljenog usera
Route::get('/profile', [AuthController::class, 'profile']);

Route::get('/sizes', [SizeController::class, 'sizes']);
Route::post('/addSize', [SizeController::class, 'addSize']);
Route::put('/updateSize', [SizeController::class, 'updateSize']);
Route::delete('/deleteSize/{id}', [SizeController::class, 'deleteSize']);
