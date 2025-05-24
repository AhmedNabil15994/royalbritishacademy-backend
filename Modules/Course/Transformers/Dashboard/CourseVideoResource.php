<?php

namespace Modules\Course\Transformers\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class CourseVideoResource extends JsonResource
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
           'title'         => $this->title,
           'status'        => $this->status,
           'video_status'        => $this->video_status,
           'created_at'    => date('d-m-Y', strtotime($this->created_at)),
       ];
    }
}
