<?php

namespace Modules\Exam\Repositories\Api;

use Modules\Apps\Http\Controllers\Api\ApiController;
use Modules\Exam\Repositories\Frontend\UserExamRepository as FrontendUserExamRepository;
use Modules\Exam\Transformers\Api\UserExamResource;

class UserExamRepository extends FrontendUserExamRepository
{
    public function examFinished($userExam)
    {
        return (new ApiController)->error(__('Exam Time finished you can retest your exam'));
    }

    public function examResult($userExam)
    {
        return (new ApiController)->response(new UserExamResource($userExam));
    }
}
