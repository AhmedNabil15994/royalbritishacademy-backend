<?php

namespace Modules\Course\Transformers\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class MyNoteCardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $notes_count = count($this->getMedia('pdf'));
             
        return [
            'id'           => $this->id,
            'title'        => $this->title,
            'category'  => $this->category?->title,
            'image'        => $this->image,
            'price'        => number_format($this->price,3),
            'notes_count'   => $notes_count,
            'is_free'        => $this->is_free,
            'download_url'        => $this->getFirstMediaUrl('pdf'),
            'sub_title'        => __('Includes :notes_count notes',['notes_count'=> $notes_count]),
        ];
    }
}
