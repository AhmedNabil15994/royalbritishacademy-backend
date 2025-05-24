<?php
use Illuminate\Support\Facades\Route;

Route::name('dashboard.')->group( function () {

    Route::get('categories/datatable'	,'CategoryController@datatable')
        ->name('categories.datatable');

    Route::get('categories/deletes'	,'CategoryController@deletes')
        ->name('categories.deletes');

    Route::resource('categories','CategoryController')->names('categories');
});

Route::name('dashboard.')->group( function () {

    Route::get('materials/datatable'	,'MaterialController@datatable')
        ->name('materials.datatable');

    Route::get('materials/deletes'	,'MaterialController@deletes')
        ->name('materials.deletes');

    Route::resource('materials','MaterialController')->names('materials');
});
