<?php

Route::group(['prefix' => 'courses'], function () {

    Route::get('/home'  , 'CourseController@home');
    Route::get('/'  , 'CourseController@index');
    Route::get('/{id}'  , 'CourseController@show');
    Route::get('/{id}/resources'  , 'CourseController@courseResources');

});

Route::group(['prefix' => 'course-review-questions'], function () {

    Route::get('/{courseId}'  , 'CourseReviewController@index');
    Route::post('/{courseId}'  , 'CourseReviewController@createQuestion');
    Route::post('answer/{questionId}'  , 'CourseReviewController@createAnswer');

});

Route::post('video/webhook', 'VideoController@webHook')->name('api.video.webhook');
Route::post('video/otp', 'VideoController@getOtp')->name('api.video.otp');
Route::post('lesson/complate/{lessonId}', 'CourseController@complateLesson')->name('api.lesson.complate');
