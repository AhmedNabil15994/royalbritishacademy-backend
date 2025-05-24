<?php

namespace Modules\Course\Transformers\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class LessonResource extends JsonResource
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
            'id'            => $this->id,
            'image'         => url($this->image),
            'course_id'     => optional($this->course)->title,
            'semester_id'   => $this->semester?->title,
            'title'         => $this->title,
            'status'        => $this->status,
            'created_at'    => date('d-m-Y', strtotime($this->created_at)),
        ];
    }
}
