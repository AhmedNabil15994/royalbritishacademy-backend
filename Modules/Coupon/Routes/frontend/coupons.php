<?php

Route::group(['prefix' => 'coupons'], function () {

    Route::get('/check_coupon/{package}', 'CouponController@checkCoupon')
        ->name('frontend.check_coupon');


});
