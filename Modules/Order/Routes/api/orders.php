<?php

use Illuminate\Support\Facades\Route;
//
Route::group(['middleware' => [ 'auth:sanctum' ]], function () {
    Route::post('/checkout', 'OrderController@create')->name('api.order.create');
});

Route::get('success-upayment', 'OrderController@successUpayment')->name('api.orders.success.upayment');
Route::get('success-free', 'OrderController@successFree')->name('api.orders.success.free');
Route::get('success-myfatoorah', 'OrderController@successMyfatoorah')->name('api.orders.success.myfatoorah');
