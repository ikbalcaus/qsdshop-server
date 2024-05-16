<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register','AuthController@register');
Route::post('/login','AuthController@login');
Route::post('/logout','AuthController@logout');
Route::post('/requestValidationKey','AuthController@requestValidationKey');
Route::post('/resetPassword','AuthController@resetPassword');
Route::post('/refresh','AuthController@refresh');
Route::post('/changePassword','AuthController@changePassword');

