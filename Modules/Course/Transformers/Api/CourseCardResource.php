<?php

namespace Modules\Course\Transformers\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class CourseCardResource extends JsonResource
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
            'intro_url'        => $this->intro_video,
            'is_favourite'        => $this->is_favourite,
            'is_subscribed'        => $this->current_user_has_access,
            'price'        => number_format($this->price,3),
            'sub_title'      => __('By') . ' ' . $this->trainer?->name,
        ];
    }
}
