<?php

// Dashboard ViewComposr
view()->composer([
    'course::dashboard.lessons.*',
], \Modules\Course\ViewComposers\Dashboard\CourseComposer::class);


view()->composer([
    'apps::frontend.index',
], \Modules\Course\ViewComposers\Frontend\CourseComposer::class);
view()->composer([
    'apps::frontend.sections.testimonial',
], \Modules\Course\ViewComposers\Frontend\CourseReviewComposer::class);
