<?php

view()->composer([
    'course::dashboard.*',
    'blog::dashboard.blogs.create',
    'blog::dashboard.blogs.edit',
    'catalog::dashboard.clients.create',
    'catalog::dashboard.clients.edit',
], \Modules\Trainer\ViewComposers\Dashboard\TrainerComposer::class);



view()->composer([
    'apps::frontend.index'
], \Modules\Trainer\ViewComposers\Frontend\TrainerComposer::class);
