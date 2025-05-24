<?php

use Illuminate\Support\Facades\Route;

Route::name('dashboard.')->group(function () {
    Route::controller('PackageController')->prefix('packages')->as('packages.')->group(function () {
        Route::get('/datatable', 'datatable')->name('datatable');
        Route::get('/deletes', 'deletes')->name('deletes');
    });

    Route::controller('SubscriptionController')->prefix('subscriptions')->as('subscriptions.')->group(function () {
        Route::get('/datatable', 'datatable')->name('datatable');

        Route::get('/today-orders', 'todayOrders')->name('today_orders');
        Route::get('/today-orders/datatable', 'toDayDatatable')->name('today_orders.datatable');

        Route::get('/deletes', 'deletes')->name('deletes');
        Route::get('/print', 'print')->name('print');

        Route::get('/getSubscriptionById/{id}', 'getSubscriptionById')->name('getSubscriptionById');
    });
    Route::controller('SuspensionController')->prefix('suspensions')->as('suspensions.')->group(function () {
        Route::get('/datatable', 'datatable')->name('datatable');
        Route::get('/deletes', 'deletes')->name('deletes');
    });
    Route::resources(
        [
            'subscriptions' => 'SubscriptionController',
            'packages'      => 'PackageController',
            'suspensions'   => 'SuspensionController'
        ],
    );
});
