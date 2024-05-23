<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\SizeController;
use App\Http\Middleware\IsAdminSuperAdmin;
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
Route::middleware(\App\Http\Middleware\IsAdminSuperAdmin::class)->post('/addSize', [SizeController::class, 'addSize']);
Route::middleware(\App\Http\Middleware\IsAdminSuperAdmin::class)->put('/updateSize', [SizeController::class, 'updateSize']);
Route::middleware(\App\Http\Middleware\IsAdminSuperAdmin::class)->delete('/deleteSize/{id}', [SizeController::class, 'deleteSize']);
//Iz nekog razloga ne prepoznaje alias adminSuperAdmin, radi jedino ovako sa rutom

Route::get('/brands',[BrandController::class,'brands']);
Route::middleware(IsAdminSuperAdmin::class)->post('/addBrand',[BrandController::class,'addBrand']);
Route::middleware(IsAdminSuperAdmin::class)->post('/updateBrand/{id}',[BrandController::class,'updateBrand']);
Route::middleware(IsAdminSuperAdmin::class)->post('/deleteBrand/{id}',[BrandController::class,'deleteBrand']);
