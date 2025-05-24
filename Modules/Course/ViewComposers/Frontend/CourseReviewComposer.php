<?php

namespace Modules\Course\ViewComposers\Frontend;

use Modules\Course\Repositories\Frontend\CourseRepository as Course;
use Illuminate\View\View;
use Modules\Course\Entities\CourseReview;

class CourseReviewComposer
{
    public $reviews;
    public function __construct()
    {
        $this->reviews =  CourseReview::where('in_slider', 1)->take(12)->get();
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('reviews', $this->reviews);
    }
}
