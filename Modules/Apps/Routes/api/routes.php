<?php

Route::post('contact-us'   , 'ContactUsController@send')->name('api.contactus.send');


Route::name('api.')->group( function () {
 
     Route::get('mobile-versions/last-version', 'MobileVersionController@lastVersion');
 });