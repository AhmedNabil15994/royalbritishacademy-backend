<?php

use Illuminate\Support\Facades\Route;

Route::name('dashboard.')->group(function () {
    ///////courses
    Route::get('courses/datatable', 'CourseController@datatable')
        ->name('courses.datatable');
    Route::get('courses/deletes', 'CourseController@deletes')
        ->name('courses.deletes');
    ///////videos
    Route::get('videos/datatable', 'VideoController@datatable')
        ->name('videos.datatable');
    Route::get('videos/deletes', 'VideoController@deletes')
        ->name('videos.deletes');
    ///////lessons
    Route::get('lessons/datatable', 'LessonController@datatable')
        ->name('lessons.datatable');
    Route::get('lessons/deletes', 'LessonController@deletes')
        ->name('lessons.deletes');
    ///////levels
    Route::get('levels/datatable', 'LevelController@datatable')
        ->name('levels.datatable');
    Route::get('levels/deletes', 'LevelController@deletes')
        ->name('levels.deletes');


    Route::get('lessoncontents/datatable', 'LessonContentController@datatable')
        ->name('lessoncontents.datatable');

    Route::get('lessoncontents/deletes', 'LessonContentController@deletes')
        ->name('lessoncontents.deletes');

    Route::delete('lessoncontents/resources/delete/{lesson}/{collection}/{resource}', 'LessonContentController@deleteAttachment')
        ->name('lessoncontents.resources.delete');



    Route::get('meetings/datatable', 'MeetingController@datatable')
        ->name('meetings.datatable');

    Route::get('meetings/deletes', 'MeetingController@deletes')
        ->name('meetings.deletes');


    Route::get('coursereviews/datatable', 'CourseReviewController@datatable')
        ->name('coursereviews.datatable');

    Route::get('coursereviews/deletes', 'CourseReviewController@deletes')
        ->name('coursereviews.deletes');


    Route::get('reviewquestions/datatable', 'ReviewQuestionController@datatable')
        ->name('reviewquestions.datatable');

    Route::get('reviewquestions/deletes', 'ReviewQuestionController@deletes')
        ->name('reviewquestions.deletes');


    Route::get('notes/datatable', 'NoteController@datatable')
    ->name('notes.datatable');

    Route::get('notes/deletes', 'NoteController@deletes')
    ->name('notes.deletes');

    Route::get('get-courses-ajax', 'CourseController@courses')->name('get-courses-ajax');
    Route::get('get-notes-ajax', 'NoteController@notes')->name('get-notes-ajax');
    Route::resources([
        'levels'              => 'LevelController',
        'videos'              => 'VideoController',
        'courses'             => 'CourseController',
        'lessons'             => 'LessonController',
        'notes'               => 'NoteController',
        'lessoncontents'      => 'LessonContentController',
        'meetings'            => 'MeetingController',
        'coursereviews'       => 'CourseReviewController',
        'reviewquestions'     => 'ReviewQuestionController',
    ]);
});
