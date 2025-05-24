<?php

namespace Modules\Slider\Transformers\Api;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Course\Transformers\Dashboard\CourseResource;

class SliderResource extends JsonResource
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
            'id' => $this->id,
            'image' => $this->getFirstMediaUrl('images'),
            'title' => $this->title,
            'description' => $this->description,
            'type' => $this->type,
            'link' => $this->link,
            'course_id' => optional($this->course)->id,
        ];
    }
}
