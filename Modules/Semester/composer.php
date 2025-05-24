<?php

view()->composer([
    'apps::frontend.index',
], Modules\Semester\ViewComposers\Frontend\SemesterComposer::class);
