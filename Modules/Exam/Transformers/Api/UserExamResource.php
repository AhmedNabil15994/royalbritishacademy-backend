<?php

namespace Modules\Exam\Transformers\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class UserExamResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'         => $this->id,
            'questions_count'      => $this->questions_count,
            'correct_answers_count'      => $this->correct_answers_count,
            'exam_result'      => $this->exam_result,
            'exam_degree'      => $this->exam_degree,
            'success_degree'      => $this->success_degree,
            'result_percentage'      => $this->result_percentage,
        ];
    }
}
