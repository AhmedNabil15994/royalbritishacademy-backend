<?php

namespace Modules\Course\Http\Controllers\Frontend;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Course\Entities\Course;
use Modules\Category\Entities\Category;
use Modules\Course\Entities\CourseReview;
use Modules\Course\Entities\ReviewQuestion;
use Modules\Course\Repositories\Frontend\CourseRepository;
use Modules\Category\Repositories\Frontend\CategoryRepository;
use Modules\Course\Entities\CourseEnrollment;
use Modules\Order\Entities\OrderCourse;

class CourseReviewController extends Controller
{
    public function CourseReview(Request $request, $id)
    {
        $course = Course::find($id);
        $review = $request->only(['desc', 'stars']);
        $review['course_id'] = $course->id;
        $courseReview = auth()->user()->courseReview()->create($review);
        if ($request->answers) {
            $courseReview->reviewQuestionAnswer()->createMany($request->answers);
        }
        return Response()->json([true, __('you\'r feedback received')]);
    }
}
