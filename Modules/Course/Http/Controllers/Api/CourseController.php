<?php

namespace Modules\Course\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Apps\Http\Controllers\Api\ApiController;
use Modules\Course\Entities\Course;
use Illuminate\Support\Facades\Route;
use Modules\Course\Entities\LessonContent;
use Modules\Course\Transformers\Api\{CourseResource,LessonResource,SemesterResource,ResourceResource};
use Modules\Course\Transformers\Api\CourseDetailsResource;
use Modules\Course\Transformers\Api\LessonContentResource;
use Modules\Order\Entities\OrderCourse;
use Modules\Course\Entities\ReviewQuestion;
use Modules\Transaction\Traits\PaymentTrait;
use Modules\Course\Repositories\Frontend\CourseRepository;
use Modules\Semester\Repositories\Frontend\SemesterRepository;

class CourseController extends ApiController
{
    use PaymentTrait;

    public function __construct(public CourseRepository $courseRepository,public LessonContent $lessonContent, public SemesterRepository $semesterRepository)
    {
        if (request()->hasHeader('authorization'))
            $this->middleware('auth:sanctum');
    }

    public function home(Request $request)
    {
        $latest = $this->courseRepository->getCourses($request,true,'courses.order','desc');//;
        $coursesData = $this->courseRepository->getCourses($request,false,'courses.order','desc');
        if(
            (isset($request->category_id) && !empty($request->category_id))
            || (isset($request->material_id) && !empty($request->material_id))
            || (isset($request->search) && !empty($request->search)) ){
            $latest = $latest->get();
            $coursesData = $coursesData->get();
        }else{
            $latest = $latest->take(8)->orderByRaw('RAND()')->get();
            $coursesData = $coursesData->take(8)->orderByRaw('RAND()')->get();
        }

        $latestCourses = CourseResource::collection($latest);
        $courses = CourseResource::collection($coursesData);

        return $this->response([
            'latest_courses' => $latestCourses,
            'courses' => $courses,
        ]);
    }

    public function index(Request $request)
    {
        $is_latest = $request->type ? ($request->type == 'is_latest' ? true : false) : false;
        return CourseResource::collection($this->courseRepository->getCourses($request, $is_latest, 'courses.order', 'asc')->paginate(10));
    }


    public function show($id)
    {
        $course = $this->courseRepository->findCourseById($id);

        if (!$course)
            return $this->error(__("Course not found"));

        return new CourseDetailsResource($course);
    }

    public function complateLesson($lessonId)
    {
        $lesson = LessonContent::whereIn('lesson_id', auth()->user()->my_courses->pluck('id')->toArray())->find($lessonId);

        if(!$lesson)
            return $this->error(__('lesson not found'));

        $complete_record = $lesson->userCompletes()->where('user_id' , auth()->id())->first();

        if(!$complete_record){

            $lesson->userCompletes()->create([
                'user_id' => auth()->id()
            ]);
        }

        return $this->response([]);
    }


    public function courseResources($id)
    {
        $currentSemester = $this->semesterRepository->currentSemester();
//        $resources = $this->lessonContent->active()->TypeResource()
//            ->whereHas('lesson',fn($q) => $q->active()->where('course_id',$id)->whereSemesterId($currentSemester->id));

        $resources = $this->lessonContent->active()->TypeResource()->whereHas('course',function ($q) use ($id,$currentSemester){
            $q->whereId($id)->with(['course_lessons'=> function($l) use($currentSemester){
                $l->active()->semesterId($currentSemester->id);
            }]);
        });
        return ResourceResource::collection($resources->orderBy('order','asc')->paginate(10));
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
