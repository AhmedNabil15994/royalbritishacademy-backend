<?php

Route::get('semesters', 'SemesterController@index')->name('frontend.semesters.index');
Route::get('semesters/media-center', 'SemesterController@mediaCenter')->name('frontend.semesters.media_center');
Route::get('semester/{slug}', 'SemesterController@show')->name('frontend.semesters.show');
