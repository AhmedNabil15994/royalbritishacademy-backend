<?php

use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'auth'], function () {
    Route::post('login', 'LoginController@postLogin')->name('api.auth.login');
    Route::post('register', 'RegisterController@register')->name('api.auth.register');
    Route::post('forget-password', 'ForgotPasswordController@forgetPassword')->name('api.auth.password.forget');

    Route::group(['prefix' => '/', 'middleware' => 'auth:sanctum'], function () {

        Route::post('logout', 'LoginController@logout')->name('api.auth.logout');
        Route::get('profile', 'ProfileController@Profile')->name('api.auth.profile');
        Route::post('profile', 'ProfileController@updateProfile')->name('api.auth.update.profile');
        Route::post('update-address', 'ProfileController@updateAddress')->name('api.auth.update.address');
        Route::post('change-password', 'ProfileController@changePassword')->name('api.auth.change.password');
        Route::delete('delete-account', 'ProfileController@deleteAccount')->name('api.auth.delete.account');
    });
});
