<?php

namespace Modules\Exam\Transformers\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
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
            'question'      => $this->question,
            'audio'      => $this->getFirstMediaUrl('audio') != '' ? $this->getFirstMediaUrl('audio') : null,
            'image'      => $this->getFirstMediaUrl('images') != '' ? $this->getFirstMediaUrl('images') : null,
            'answers'      => AnswerResource::collection($this->answers()->get()),
        ];
    }
}
