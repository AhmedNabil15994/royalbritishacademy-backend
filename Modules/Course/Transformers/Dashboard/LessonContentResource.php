<?php

namespace Modules\Course\Transformers\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class LessonContentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $columns = [
            'id'            => $this->id,
            'title'         => $this->title,
            'lesson_id'        => $this->course?->title,
            'deleted_at'    => $this->deleted_at,
            'created_at'    => date('d-m-Y', strtotime($this->created_at)),
        ];
        return $columns;
    }
}
