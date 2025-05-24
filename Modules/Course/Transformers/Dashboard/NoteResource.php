<?php

namespace Modules\Course\Transformers\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Category\Transformers\Dashboard\CategoryResource;

class NoteResource extends JsonResource
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
            'title'        => $this->title,
            'category_id'  => $this->category?->parent?->title . '-' . $this->category?->title,
            'trainer_id'   => $this->trainer?->name,
            'price'        => $this->price,
            'class_time'   => $this->class_time,
            'created_at'   => date('d-m-Y', strtotime($this->created_at)),
        ];
    }
}
