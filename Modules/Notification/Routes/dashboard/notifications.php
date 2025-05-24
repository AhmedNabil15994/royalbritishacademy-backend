<?php

Route::group(['prefix' => 'notifications'], function () {

    Route::get('/', 'NotificationController@index')
        ->name('dashboard.notifications.index')
        ->middleware(['permission:show_notifications']);

    Route::get('datatable', 'NotificationController@datatable')
        ->name('dashboard.notifications.datatable')
        ->middleware(['permission:show_notifications']);

    Route::get('create', 'NotificationController@notifyForm')
        ->name('dashboard.notifications.create')
        ->middleware(['permission:add_notifications']);

    Route::post('send', 'NotificationController@push_notification')
        ->name('dashboard.notifications.store')
        ->middleware(['permission:add_notifications']);

    Route::delete('{id}', 'NotificationController@destroy')
        ->name('dashboard.notifications.destroy')
        ->middleware(['permission:delete_notifications']);

    Route::get('deletes', 'NotificationController@deletes')
        ->name('dashboard.notifications.deletes')
        ->middleware(['permission:delete_notifications']);

});
