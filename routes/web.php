<?php

use Illuminate\Support\Facades\Route;
use App\Mail\ValidationMail;
Route::get('/', function () {

    return view('welcome');

    //test za slanje koda
//Mail::to('laravel.praksa@gmail.com')->send(new ValidationMail('123456'));


});
