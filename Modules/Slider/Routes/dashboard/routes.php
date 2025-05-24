<?php

Route::group(['prefix' => 'sliders'], function () {
    Route::get('/', 'SliderController@index')
    ->name('dashboard.sliders.index');

    Route::get('datatable', 'SliderController@datatable')
    ->name('dashboard.sliders.datatable');

    Route::get('create', 'SliderController@create')
    ->name('dashboard.sliders.create');

    Route::post('/', 'SliderController@store')
    ->name('dashboard.sliders.store');

    Route::get('{id}/edit', 'SliderController@edit')
    ->name('dashboard.sliders.edit');

    Route::put('{id}', 'SliderController@update')
    ->name('dashboard.sliders.update');

    Route::delete('{id}', 'SliderController@destroy')
    ->name('dashboard.sliders.destroy');

    Route::get('deletes', 'SliderController@deletes')
    ->name('dashboard.sliders.deletes');

    Route::get('{id}', 'SliderController@show')
    ->name('dashboard.sliders.show');
});
