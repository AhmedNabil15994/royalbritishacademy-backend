<?php

use Illuminate\Support\Facades\Route;

Route::get('/levels', 'LevelController@levels')->name('frontend.levels.index');
    Route::get('/levels/{id}', 'LevelController@showLevel')->name('frontend.levels.show');


Route::get('courses', 'CourseController@index')->name('frontend.courses');
    Route::get('courses/{slug}', 'CourseController@show')->name('frontend.courses.show');
    Route::post('courses/review/{id}', 'CourseReviewController@CourseReview')->name('frontend.courses.review');

    Route::get('video-details', 'VideoController@videoResponse')->name('frontend.videos');



    Route::post('/sync-user-view', 'UserVideoController')->name('course.make.view');
Route::get('/course-live/{id}', 'CourseController@live')->name('course.live');
Route::get('/course-certification/{id}', 'CourseController@CourseCertification')->name('frontend.course.certification');

Route::post('courses/buy/{courseId}', 'CourseController@buy')->name('frontend.courses.buy');
