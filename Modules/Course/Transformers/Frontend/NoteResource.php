<?php

namespace Modules\Course\Transformers\Frontend;

use Illuminate\Http\Resources\Json\JsonResource;

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
            'category'  => $this->category?->title,
            'image'        => asset($this->image),
            'slug'         => $this->slug,
            'price'        => $this->price,
            'sub_title'        => __('Includes :notes_count notes',['notes_count'=> count($this->getMedia('pdf'))]),
        ];
    }
}
