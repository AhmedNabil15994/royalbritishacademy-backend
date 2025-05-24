<?php

namespace Modules\Course\Transformers\Frontend;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Category\Transformers\Dashboard\CategoryResource;

class CourseResource extends JsonResource
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
            'image'        => $this->image,
            'slug'         => $this->slug,
            'price'        => $this->price,
            'sub_title'      => __('By') . ' ' . $this->trainer?->name,
        ];
    }
}
