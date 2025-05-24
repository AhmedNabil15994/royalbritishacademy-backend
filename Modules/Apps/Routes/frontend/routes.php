<?php

Route::get('/', function () {
    return view('apps::frontend.index');
})->name('frontend.home');
