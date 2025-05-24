<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'trainers'], function () {
    Route::get('/', 'TrainerController@index')->name('frontend.trainers.index');
    Route::get('/apply', 'TrainerController@instructorApply')->name('frontend.trainers.apply.form');
    Route::post('/apply', 'TrainerController@sendInstructorApply')->name('frontend.trainers.apply');
    Route::get('profile/{id}', 'TrainerController@show')->name('frontend.trainers.show');
});
