<?php

view()->composer([
    'apps::frontend.index',
], Modules\Slider\ViewComposers\Frontend\SliderComposer::class);
