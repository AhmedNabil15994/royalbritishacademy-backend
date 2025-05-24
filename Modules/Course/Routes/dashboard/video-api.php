<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'video-api'], function () {
    Route::post('/', 'VideoController@apiUploadVideo')->name('dashboard.videos.api.upload');
});
