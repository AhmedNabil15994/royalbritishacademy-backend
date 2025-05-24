<?php

namespace Modules\Course\Transformers\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class CourseReviewResource extends JsonResource
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
            'course_id'     => optional($this->course)->title,
            'user_id'       => $this->user->name,
            'stars'         => $this->stars,
            'status'        => $this->status,
            'deleted_at'    => $this->deleted_at,
            'created_at'    => date('d-m-Y', strtotime($this->created_at)),
        ];
    }
}
