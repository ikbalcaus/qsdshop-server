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

    //test za slanje emailova
//Mail::to('laravel.praksa@gmail.com')->send(new ValidationMail('123456'));
//Mail::to('laravel.praksa@gmail.com')->send(new PasswordReset('https://youtube.com'));
//Mail::to('laravel.praksa@gmail.com')->send(new ProductInStock('Adnan',"Nike patike",'https://www.intersport.ba'));


// $order = new Order();
// $order->user = new Order();
// $order->user->first_name = 'Adnan';
// $order->user->last_name = 'Voloder';
// $order->user->email = 'adnan@gmail.com';
// $order->city = 'Mostar';
// $order->address = 'Adresa 12';
// $order->zip = '88000';
// $order->phone = '123-456-789';
// $order->orderProductSize = new OrderProductSize();
// $order->orderProductSize->productSize = new ProductSize();
// $order->orderProductSize->productSize->product = new Product();
// $order->orderProductSize->productSize->product->name = 'Trenerka';
// $order->orderProductSize->productSize->product->brands = new Brand();
// $order->orderProductSize->productSize->product->brands->name = 'Nike';
// $order->orderProductSize->productSize->sizes = new Size();
// $order->orderProductSize->productSize->sizes->size = 'XL';
// $order->orderProductSize->productSize->product->price = '$19.99';
// Mail::to('laravel.praksa@gmail.com')->send(new OrderConfirmation($order));

});
