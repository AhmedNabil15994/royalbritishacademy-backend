<?php

Route::group(['prefix' => 'categories'], function () {

    Route::get('/'  , 'CategoryController@categories');
    Route::get('/{id}'  , 'CategoryController@show');

});

Route::group(['prefix' => 'materials'], function () {

    Route::get('/'  , 'CategoryController@materials');

});
