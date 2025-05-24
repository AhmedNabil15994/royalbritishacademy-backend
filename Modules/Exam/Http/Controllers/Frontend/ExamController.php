<?php

namespace Modules\Exam\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Modules\Exam\Entities\Exam;
use Illuminate\Routing\Controller;
use Modules\Course\Entities\Course;
use Modules\Exam\Entities\UserExam;
use Modules\Exam\Http\Requests\Frontend\UserExamRequest;
use Modules\Exam\Repositories\Frontend\UserExamRepository;

class ExamController extends Controller
{
    public $userExamRepository;

    public function __construct(UserExamRepository $userExamRepository)
    {
        $this->userExamRepository = $userExamRepository;
    }

    public function index()
    {
        $exams = Exam::has('questions')->get();

        return view('exam::frontend.exams.index', compact('exams'));
    }
    public function show($id)
    {
        $exam = Exam::with('questions')->find($id);

        $userExam = $this->userExamRepository->findOrCreateUserExam($id);
        return view('exam::frontend.exams.show', compact('exam', 'userExam'));
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
        $userExam=optional(auth()->user()->userExams()->where('exam_id', $id)->first())->delete();
        return redirect()->route('frontend.exams.show', $id);
    }
}
