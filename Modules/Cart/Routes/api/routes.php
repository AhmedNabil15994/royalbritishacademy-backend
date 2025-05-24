<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'cart' ], function () {
    Route::get('/', 'CartController@index')->name('api.cart.index');
    Route::post('add/{id}', 'CartController@add')->name('api.cart.add');
    Route::post('add-coupon', 'CartController@addCoupon')->name('api.cart.add.coupon');
    Route::delete('remove-coupon', 'CartController@removeCoupon')->name('api.cart.remove.coupon');
    Route::delete('remove/{id}', 'CartController@remove')->name('api.cart.remove');
    Route::post('clear', 'CartController@clear')->name('api.cart.clear');
});
