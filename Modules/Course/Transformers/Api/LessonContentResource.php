<?php

namespace Modules\Course\Transformers\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class LessonContentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $access = $this->course?->current_user_has_access;
        return [
            'id'           => $this->id,
            'title'        => $this->title,
            'can_access'        => $access,
            'is_completed'        => $this->is_completed,
            'thumb'        => $this->video?->thumb,
            'duration'        => $this->video?->video_minutes,
            'video_id'        => $this->video?->video_link,
            'resources'        => ResourceResource::collection($this->getMedia('resources')),
        ];
    }
}
