<?php
use Illuminate\Support\Facades\Route;

Route::name('dashboard.')->group( function () {

    Route::get('academicyears/datatable'	,'AcademicYearController@datatable')
        ->name('academicyears.datatable');

    Route::get('academicyears/deletes'	,'AcademicYearController@deletes')
        ->name('academicyears.deletes');

    Route::resource('academicyears','AcademicYearController')->names('academicyears');
});