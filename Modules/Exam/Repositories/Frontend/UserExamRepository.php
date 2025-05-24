<?php

namespace Modules\Exam\Repositories\Frontend;

use Illuminate\Support\Arr;
use Modules\Exam\Entities\Exam;
use Modules\Exam\Entities\UserExam;
use Modules\Exam\Entities\QuestionAnswer;

class UserExamRepository
{
    public function __construct()
    {
        $this->model = UserExam::class;
    }


    public function findOrCreateUserExam($id)
    {
        return auth()->user()->userExams()->where(['exam_id' => $id])->firstOrCreate(['exam_id' => $id]);
    }

    public function create($request, $id)
    {
        $exam = Exam::find($id);
        $userExam = $this->findOrCreateUserExam($id);

        if ($exam->duration !== null && !$userExam->exam_is_running) {
            return $this->examFinished($userExam);
        }

        $this->handelExamDegree($exam, $userExam, $request);
        return $this->examResult($userExam);
    }

    public function examFinished($userExam)
    {
        return redirect()->back()->with([
            'msg'   => __('Exam Time finished'),
            'html'   => '<a class="btn btn main-custom-btn"
                    href="' . route('frontend.exams.exam.retest', $userExam->exam->id) . '">' . __('Re test') . '</a>',
            'alert' => 'danger'
        ]);
    }

    public function examResult($userExam)
    {
        return redirect()->route('frontend.exams.exam-result', $userExam->id);
    }

    public function handelExamDegree($exam, &$userExam, $request)
    {
        $correctAnswersCount = 0;
        $examResult = 0;

        foreach ($request['answers'] as $answer) {
            $data = $answer;
            $answer = QuestionAnswer::where(
                [
                    'id' => data_get($data, 'answer'),
                    'question_id' => data_get($data, 'question')
                ]
            )->first();
            $data['question_id'] = Arr::pull($data, 'question');
            if ($answer) {
                $data['question_answer_id'] = $answer->id;
                $data['degree'] = $answer->degree;
                if ($data['degree'] > 0) {
                    $correctAnswersCount++;
                    $examResult += $data['degree'];
                }
            } else {
                $data['question_answer_id'] = null;
                $data['degree'] = 0;
            }

            $userExam->userExamAnswers()->updateOrCreate(
                [
                    'question_id' => $data['question_id']
                ],
                $data
            );
        }
        $userExam->update([
            'questions_count'       => count($request['answers']),
            'correct_answers_count' => $correctAnswersCount,
            'exam_result'           => $examResult,
            'exam_degree'           => $exam->degree,
            'success_degree'        => $exam->success_degree,
        ]);
    }
}
