<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);
Route::post('/logout','AuthController@logout');
Route::post('/requestValidationKey',[AuthController::class,'requestValidationKey']);
Route::post('/resetPassword','AuthController@resetPassword');
Route::post('/refresh','AuthController@refresh');
Route::post('/changePassword','AuthController@changePassword');

