<?php

namespace Modules\Course\Transformers\ClientSide;

use Illuminate\Http\Resources\Json\JsonResource;
use IlluminateAgnostic\Str\Support\Carbon;

class ReviewAnswerResource extends JsonResource
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
            'answer'        => $this->answer,
            'username'        => $this->user?->name,
            'created_at'        => Carbon::parse($this->created_at)->toDateString(),
        ];
    }
}
