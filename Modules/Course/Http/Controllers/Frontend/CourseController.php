<?php

namespace Modules\Course\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Routing\Controller;
use Modules\Course\Entities\Course;
use Illuminate\Support\Facades\Route;
use Modules\Category\Entities\Category;
use Modules\Order\Entities\OrderCourse;
use Modules\Course\Entities\CourseReview;
use Modules\Course\Entities\ReviewQuestion;
use Modules\Transaction\Traits\PaymentTrait;
use Modules\Course\Repositories\Frontend\CourseRepository;
use Modules\Category\Repositories\Frontend\CategoryRepository;
use Modules\Semester\Repositories\Frontend\SemesterRepository;
use Modules\Order\Repositories\Frontend\OrderRepository as Order;

class CourseController extends Controller
{
    use PaymentTrait;

    public function __construct(public Order $order, public CourseRepository $courseRepository, public CategoryRepository $category, public SemesterRepository $semesterRepository)
    {
    }

    public function index(Request $request)
    {

        $data['courses'] = $this->courseRepository->getCoursesByCategory()->get();

        $data['mainCategories'] = $this->category->mainCategories();
        return view('course::frontend.courses.index', $data);
    }


    public function show($slug)
    {
        $course = $this->courseRepository->findCourseBySlug($slug);

        if(!$course->current_user_hasAccess && !$course->status){
            abort(404);
        }

        if (!checkRouteLocale($course, $slug)) {
            return redirect()->route(Route::currentRouteName(), [$course->slug]);
        }
        $semesters = $this->semesterRepository->getAllSemesters();
        $currentSemester = $this->semesterRepository->currentSemester();
        $reviewQuestions = ReviewQuestion::active()->get();
        return view('course::frontend.courses.show', compact('course', 'reviewQuestions', 'semesters', 'currentSemester'));
    }

    public function live($id)
    {
        $course = Course::where('is_live', 1)->with('trainer', 'meeting')->find($id);
        if (count($course->subscribed) <= 0 && $course->trainer_id != auth()->id()) {
            abort(404);
        }
        return view('course::frontend.courses.zoom-show', compact('course'));
    }

    public function buy(Request $request, $id)
    {
        if (!auth()->check()) {
            return redirect()->route('frontend.register');
        } else {
            $user = auth()->user();
        }

        $data['user_id'] = $user->id;

        $course = $this->courseRepository->findCourseById($id);
        $order =  $this->order->BuySingleCourse($request, $course);
        $payment = $this->getPaymentGateway('tap');
        $data = $payment->send($order, 'orders');
        return redirect($data['url']);
    }


    public function CourseCertification($id)
    {
        $orderCourse = OrderCourse::with('course', 'user')
            ->where('course_id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();



        // abort_if(!$orderCourse->course->isFinished() || !$orderCourse->course->is_certificated, 404);


        return  view('course::frontend.courses.certification', compact('orderCourse'));

        // $pdf = PDF::loadView('course::frontend.courses.certification', compact('orderCourse'))
        //     ->setPaper([0, 0, 567.00, 883.80], 'landscape');

        // return $pdf->stream();
        // return $pdf->download('certification');
    }
}
