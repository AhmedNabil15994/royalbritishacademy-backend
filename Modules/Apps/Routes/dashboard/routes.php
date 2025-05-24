<?php

//use Vsch\TranslationManager\Translator;


Route::group(['prefix' => '/' , 'middleware' => [ 'dashboard.auth','check.permission']], function() {

  Route::get('/' , 'DashboardController@index')->name('dashboard.home');

//  Route::group(['prefix' => 'translations'], function () {
//      Translator::routes();
//  });

  Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

});




Route::group(['prefix' => 'mobile-versions'], function () {

  Route::get('/' ,'MobileVersionController@index')
      ->name('dashboard.mobile-versions.index')
      // ->middleware(['permission:show_mobile-versions']);
      ;

  Route::get('datatable'	,'MobileVersionController@datatable')
      ->name('dashboard.mobile-versions.datatable')
      // ->middleware(['permission:show_mobile-versions']);
      ;

  Route::get('create'		,'MobileVersionController@create')
      ->name('dashboard.mobile-versions.create')
      // ->middleware(['permission:add_mobile-versions']);
      ;

  Route::post('/'			,'MobileVersionController@store')
      ->name('dashboard.mobile-versions.store')
      // ->middleware(['permission:add_mobile-versions']);
      ;

  Route::get('{id}/edit'	,'MobileVersionController@edit')
      ->name('dashboard.mobile-versions.edit')
      // ->middleware(['permission:edit_mobile-versions']);
      ;

  Route::put('{id}'		,'MobileVersionController@update')
      ->name('dashboard.mobile-versions.update')
      // ->middleware(['permission:edit_mobile-versions']);
      ;

  Route::delete('{id}'	,'MobileVersionController@destroy')
      ->name('dashboard.mobile-versions.destroy')
      // ->middleware(['permission:delete_mobile-versions']);
      ;

  Route::get('deletes'	,'MobileVersionController@deletes')
      ->name('dashboard.mobile-versions.deletes')
      // ->middleware(['permission:delete_mobile-versions']);
      ;

  Route::get('{id}','MobileVersionController@show')
      ->name('dashboard.mobile-versions.show')
      // ->middleware(['permission:show_mobile-versions']);
      ;

});
