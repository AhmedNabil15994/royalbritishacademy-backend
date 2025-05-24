<?php

use Illuminate\Support\Facades\Route;

Route::name('dashboard.')->group(function () {

    Route::controller('AdminController')->group(function () {
        Route::get('admins/datatable', 'datatable')->name('admins.datatable');
        Route::get('admins/deletes', 'deletes')->name('admins.deletes');
    });

    Route::controller('UserController')->group(function () {
        Route::get('users/datatable', 'datatable')->name('users.datatable');
        Route::get('users/deletes', 'deletes')->name('users.deletes');
    });


    Route::resources([
        'users'  => 'UserController',
        'admins' => 'AdminController'
    ]);
});
