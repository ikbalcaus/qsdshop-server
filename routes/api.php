<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\FilterController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DiscountController;
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
Route::middleware([\App\Http\Middleware\IsAdminSuperAdmin::class])->group(function () {
    Route::post('/addProduct', [ProductController::class, 'addProduct']);
    Route::post('/updateProduct', [ProductController::class, 'updateProduct']);
    Route::delete('/deleteProduct/{id}', [ProductController::class, 'deleteProduct']);
});
Route::middleware('auth:api')->post('/rateProduct', [ProductController::class, 'rateProduct']);
Route::post('/editRateProduct', [ProductController::class, 'editRateProduct']);
Route::delete('/deleteImage/{id}', [ProductController::class, 'deleteImage']);

Route::get('/colors', [ColorController::class, 'colors']);
Route::middleware([\App\Http\Middleware\IsAdminSuperAdmin::class])->group(function () {
    Route::post('/addColor', [ColorController::class, 'addColor']);
    Route::put('/updateColor/{id}', [ColorController::class, 'updateColor']);
    Route::delete('/deleteColor/{id}', [ColorController::class, 'deleteColor']);
});

//dodaj middleware
Route::middleware([\App\Http\Middleware\IsAdminSuperAdmin::class])->group(function () {
Route::get('/getUser/{id}', [UserController::class, 'getUser']);
Route::get('/users', [UserController::class, 'users']);
});
Route::middleware('auth:api')->group(function () {
    Route::put('/updateUser', [UserController::class, 'updateUser']);
    Route::delete('/deleteUser', [UserController::class, 'deleteUser']);
});
Route::middleware([\App\Http\Middleware\IsAdminSuperAdmin::class])->group(function () {
    Route::post('/banUser', [UserController::class, 'banUser']);
    Route::put('/updateRole', [UserController::class, 'updateRole']);
});

Route::post('/search', [FilterController::class, 'search']);
Route::get('/filterProducts', [FilterController::class, 'filterProducts']);

Route::middleware('auth:api')->get('/getFavorites', [FavoriteController::class, 'getFavorites']);
Route::middleware('auth:api')->post('/handleFavorite', [FavoriteController::class, 'handleFavorite']);

Route::get('/getDiscounts', [DiscountController::class, 'getDiscounts']);
Route::get('/getUpcomingDiscounts', [DiscountController::class, 'getUpcomingDiscounts']);
Route::middleware([\App\Http\Middleware\IsAdminSuperAdmin::class])->group(function () {
    Route::post('addDiscount', [DiscountController::class, 'addDiscount']);
    Route::delete('/deleteDiscount/{id}', [DiscountController::class, 'deleteDiscount']);
});

Route::middleware('auth:api')->put('/updateState', [OrderController::class, 'updateState']);
Route::middleware([\App\Http\Middleware\IsAdminSuperAdmin::class])->group(function () {
Route::get('/getOrders', [OrderController::class, 'getOrders']);
Route::get('/getOrdersPerUser', [OrderController::class, 'getOrdersPerUser']);
});

Route::post('/payment', [PaymentController::class, 'payment']);



