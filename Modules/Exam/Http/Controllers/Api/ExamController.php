<?php

namespace Modules\Exam\Http\Controllers\Api;

use Modules\Apps\Http\Controllers\Api\ApiController;
use Modules\Exam\Entities\Exam;
use Illuminate\Routing\Controller;
use Modules\Course\Entities\Course;
use Modules\Exam\Entities\UserExam;
use Modules\Exam\Http\Requests\Frontend\UserExamRequest;
use Modules\Exam\Repositories\Api\UserExamRepository;
use Modules\Exam\Transformers\Api\{ExamResource,QuestionResource};

class ExamController extends ApiController
{
    public $userExamRepository;

    public function __construct(UserExamRepository $userExamRepository)
    {
        $this->userExamRepository = $userExamRepository;
    }

    public function index($courseId)
    {
        $exams = Exam::has('questions')->whereHas('lessonContents', fn($q) => $q->active()->whereHas('lesson', fn($q) => $q->where('course_id', $courseId)))->paginate(10);

        return ExamResource::collection($exams);
    }
    public function show($id)
    {
        $exam = Exam::with('questions')->find($id);
        $questions = $exam->questions()->paginate(5);
        $this->userExamRepository->findOrCreateUserExam($id);

        return QuestionResource::collection($questions);
    }

    public function levelTest(UserExamRequest $request, $id)
    {
        return  $this->userExamRepository->create($request->all(), $id);
    }

    public function examResult($id)
    {
        $userExam=UserExam::where('user_id', auth()->id())->with('exam')->findOrFail($id);
        $recommendedCourses=Course::inRandomOrder()->limit(5)->get();

        return view('exam::frontend.exams.show-result', compact('userExam', 'recommendedCourses'));
    }

    public function examRetest($id)
    {
        $userExam = optional(auth()->user()->userExams()->where('exam_id', $id)->first())->delete();
        return $this->response([]);
    }
}
