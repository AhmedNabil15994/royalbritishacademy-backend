<?php

// Dashboard ViewComposr
view()->composer([
    'category::dashboard.categories.*',
    'company::dashboard.companies.*',
    'course::dashboard.courses.*',
    'course::dashboard.notes.create',
    'course::dashboard.notes.edit',
    'apps::frontend.*',
], \Modules\Category\ViewComposers\Dashboard\CategoryComposer::class);
view()->composer([
    'apps::frontend.*',
], \Modules\Category\ViewComposers\Frontend\CategoryComposer::class);
