<?php

use Modules\Category\Entities\Category;

Route::get('categories/{category}', 'ShowCategoryController')->name('frontend.categories.show');
