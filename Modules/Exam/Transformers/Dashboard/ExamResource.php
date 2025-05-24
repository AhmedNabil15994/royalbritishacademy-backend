<?php

namespace Modules\Exam\Transformers\Dashboard;

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
                 'deleted_at' => $this->deleted_at,
                 'created_at' => date('d-m-Y', strtotime($this->created_at)),
              ];
    }
}
