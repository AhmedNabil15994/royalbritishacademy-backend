<?php

namespace Modules\Exam\Transformers\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class ExamResource extends JsonResource
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
            'title'      => $this->title,
            'degree'      => $this->degree,
            'success_degree'      => $this->success_degree,
            'duration'      => convertDurationToTimeFormat($this->duration),
        ];
    }
}
