<?php

use Illuminate\Support\Facades\Route;
use App\Mail\ValidationMail;
use App\Mail\PasswordReset;
use App\Mail\OrderConfirmation;
use App\Mail\ProductInStock;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderProductSize;
use App\Models\ProductSize;
use App\Models\Size;
use App\Models\Brand;

Route::get('/', function () {

   return view('welcome');
});
