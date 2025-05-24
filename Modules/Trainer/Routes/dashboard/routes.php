<?php

use Illuminate\Support\Facades\Route;

Route::name('dashboard.')->group(function () {
    Route::get('trainers/datatable', 'TrainerController@datatable')
        ->name('trainers.datatable');

    Route::get('trainers/deletes', 'TrainerController@deletes')
        ->name('trainers.deletes');

    Route::resource('trainers', 'TrainerController')->names('trainers');

    Route::get('applies/datatable', 'ApplyController@datatable')
        ->name('applies.datatable');

    Route::get('applies/deletes', 'ApplyController@deletes')
        ->name('applies.deletes');

    Route::resource('applies', 'ApplyController')->names('applies');
});
