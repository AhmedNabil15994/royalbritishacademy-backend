<?php

namespace Modules\Course\ViewComposers\Frontend;

use Modules\Course\Repositories\Frontend\CourseRepository as Course;
use Illuminate\View\View;
use Cache;

class CourseComposer
{
    public function __construct(Course $course)
    {
        $this->courses =  $course->getLimitedCourses();
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('courses', $this->courses);
    }
}
