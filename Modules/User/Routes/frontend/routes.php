<?php

Route::name('frontend.profile.')->prefix('profile')->group(function () {
    
    Route::get('/', 'ProfileController@index')->name('index');

    Route::get('/edit', 'ProfileController@edit')->name('edit');
    Route::post('/update', 'ProfileController@update')->name('update');
    
    Route::get('/my-courses', 'ProfileController@myCourses')->name('my-courses');
});
