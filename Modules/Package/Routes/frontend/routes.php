<?php

Route::controller('PackageController')->prefix('/packages')->name('frontend.packages.')->group(function () {
    Route::get('', 'index')->name('index');

    Route::post('renew-subscribe', 'renew')->name('renew');
    Route::post('pause-subscription', 'pauseSubscription')->name('pause.subscription');

    Route::get('{package}', 'show')->name('show');


    Route::get('{package}/subscribeForm', 'subscribeForm')->name('subscribeForm');
    Route::post('{package}/subscribe', 'subscribe')->name('subscribe');
});

Route::controller('AfterPaidController')->group(function () {
    Route::get('success', 'success')->name('frontend.subscriptions.success');
    Route::get('failed', 'failed')->name('frontend.subscriptions.failed');
    Route::get('notify', 'updatePaidStatus')->name('frontend.subscriptions.notify');
});
