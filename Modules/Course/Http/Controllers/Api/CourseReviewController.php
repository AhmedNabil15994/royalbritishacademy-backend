<?php

namespace Modules\Course\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Apps\Http\Controllers\Api\ApiController;
use Modules\Course\Http\Requests\Client\{AddAnswerRequest,AddQuestionRequest};
use Modules\Course\Repositories\ClientSide\ReviewQuestionRepository;
use Modules\Course\Transformers\ClientSide\{ReviewAnswerResource,ReviewQuestionResource};

class CourseReviewController extends ApiController
{

    public function __construct(public ReviewQuestionRepository $reviewQuestionRepository)
    {
        $this->middleware('auth:sanctum', ['only' => ['createQuestion','createAnswer']]);
    }

    public function index(Request $request, $courseId)
    {
        return ReviewQuestionResource::collection($this->reviewQuestionRepository->getQuestionsAndAnswersWithCourseId($courseId));
    }

    public function createQuestion(AddQuestionRequest $request, $courseId)
    {
        try {
            $create = $this->reviewQuestionRepository->addQuestion($request, $courseId);
        
            if ($create) {
                $create->refresh();
                return $this->response(new ReviewQuestionResource($create));
            }

            return $this->error(__('apps::dashboard.messages.failed'));
        } catch (\PDOException $e) {
            return $this->error($e->errorInfo[2]);
        }
    }

    public function createAnswer(AddAnswerRequest $request,$questionId)
    {
        try {
            $create = $this->reviewQuestionRepository->addAnswer($request,$questionId);
        
            if ($create) {
                $create->refresh();
                return $this->response(new ReviewAnswerResource($create));
            }

            return $this->error(__('apps::dashboard.messages.failed'));
        } catch (\PDOException $e) {
            return $this->error($e->errorInfo[2]);
        }
    }
}
