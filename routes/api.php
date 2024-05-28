<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;

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

Route::get('/sizes', [SizeController::class, 'sizes']);
Route::middleware([\App\Http\Middleware\IsAdminSuperAdmin::class])->group(function () {
    Route::post('/addSize', [SizeController::class, 'addSize']);
    Route::put('/updateSize', [SizeController::class, 'updateSize']);
    Route::delete('/deleteSize/{id}', [SizeController::class, 'deleteSize']);
});//Iz nekog razloga ne prepoznaje alias adminSuperAdmin, radi jedino ovako sa rutom

Route::get('/categories', [CategoryController::class, 'categories']);
Route::middleware([\App\Http\Middleware\IsAdminSuperAdmin::class])->group(function () {
    Route::post('/addCategory', [CategoryController::class, 'addCategory']);
    Route::put('/updateCategory', [CategoryController::class, 'updateCategory']);
    Route::delete('/deleteCategory/{id}', [CategoryController::class, 'deleteCategory']);
});

Route::get('/brands', [BrandController::class, 'brands']);
Route::middleware([\App\Http\Middleware\IsAdminSuperAdmin::class])->group(function () {
    Route::post('/addBrand', [BrandController::class, 'addBrand']);
    Route::put('/updateBrand/{id}', [BrandController::class, 'updateBrand']);
    Route::delete('/deleteBrand/{id}', [BrandController::class, 'deleteBrand']);
});

Route::get('/getProducts', [ProductController::class, 'getProducts']);
Route::get('/getProduct/{id}', [ProductController::class, 'getProduct']);
Route::post('/addProduct', [ProductController::class, 'addProduct']);
Route::post('/updateProduct', [ProductController::class, 'updateProduct']);
Route::delete('/deleteProduct/{id}', [ProductController::class, 'deleteProduct']);
Route::post('/rateProduct', [ProductController::class, 'rateProduct']);
Route::post('/editRateProduct', [ProductController::class, 'editRateProduct']);
