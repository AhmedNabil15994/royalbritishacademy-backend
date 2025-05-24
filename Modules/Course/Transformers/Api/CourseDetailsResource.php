<?php

namespace Modules\Course\Transformers\Api;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Course\Repositories\Frontend\CourseRepository;

class CourseDetailsResource extends JsonResource
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
            'teacher'  => $this->trainer?->name,
            'image'        => asset($this->image),
            'thumb'        => $this->video?->thumb,
            'duration'        => $this->video?->video_minutes,
            'intro'        => [
                'playbackInfo' => null,
                'otp' => null,
            ],
            'video_id'        => $this->video?->video_link,
            'is_favourite'        => $this->is_favourite,
            'is_subscribed'        => $this->current_user_has_access,
            'User_complete_percentage'        => $this->User_complete_percentage,
            'class_time_hr'        => $this->class_time,
            'students_count'        => $this->subscriptions_count,
            'lessons_count'        => $this->lessons_count,
            'price'        => number_format($this->price,3),
            'offer' => new CourseOfferResource($this->offer),
            'sub_title'      => __('By') . ' ' . $this->trainer?->name,
            'short_desc'        => $this->short_desc,
            'description'        => $this->description,
            'about_course'        => $this->requirements,
            'lessons'        => LessonContentResource::collection($this->lessons()->active()->orderBy('order', 'asc')->get()),
            'related_courses' => CourseResource::collection((new CourseRepository)->getRelatedCourses($this->categories->pluck('id')->toArray())
                ->where('id','!=',$this->id)->take(6)->orderBy('id', 'desc')->get())
        ];
    }
}
