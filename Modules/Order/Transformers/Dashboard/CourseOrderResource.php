<?php

namespace Modules\Order\Transformers\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class CourseOrderResource extends JsonResource
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
           'id'                   => $this->id,
           'title'             => $this->title,
           'trainer'             => $this->trainer?->name,
           'price'             => number_format($this->pivot->total,3),
       ];
    }
}
