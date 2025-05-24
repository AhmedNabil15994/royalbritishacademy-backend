<?php

namespace Modules\Course\Transformers\ClientSide;

use Illuminate\Http\Resources\Json\JsonResource;
use IlluminateAgnostic\Str\Support\Carbon;

class ReviewQuestionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'           => $this->id,
            'question'        => $this->question,
            'username'        => $this->user?->name,
            'created_at'        => Carbon::parse($this->created_at)->toDateString(),
            'answers'        => ReviewAnswerResource::collection($this->answers()->active()->oldest()->get())->jsonSerialize(),
        ];
    }
}
