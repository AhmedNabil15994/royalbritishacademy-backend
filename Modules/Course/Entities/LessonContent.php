<?php

namespace Modules\Course\Entities;

use Modules\Core\Traits\ScopesTrait;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\HasTranslations;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;

class LessonContent extends Model implements HasMedia
{
    use HasTranslations;
    use ScopesTrait;
    use InteractsWithMedia;
    use SoftDeletes;

    public $fillable = ['title', 'order', 'type', 'course_id', 'video_id', 'video_link', 'exam_id','status'];
    public $translatable  = ['title'];

    // public function scopeActive($query)
    // {
    //     return $query->where('status', true)->where(function ($q) {
    //         $q->where('loading_status', 'loaded');
    //     });
    // }


    /**
     * Get the user that owns the LessonContent
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function video()
    {
        return $this->morphOne(Video::class, 'videoable');
    }


    /**
     * Get the user that owns the LessonContent
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function course()
    {
        return $this->belongsTo(Course::class,'course_id');
    }


    public function availableTypes(): array
    {
        return __('course::dashboard.lessoncontents.form.types');
    }

    public function userCompletes()
    {
        return $this->hasMany(UserComplation::class, 'lesson_content_id');
    }

    public function getIsCompletedAttribute()
    {
        return auth()->check() && $this->userCompletes()->where('user_id', auth()->id())->first() ? true : false;
    }

    public function getResourceFileAttribute()
    {
        return $this->getFirstMediaUrl('resources') != "" ? $this->getFirstMediaUrl('resources') : '';
    }

    public function scopeTypeVideo($query)
    {
        return $query->where('type','video');
    }

    public function scopeTypeResource($query)
    {
        return $query->where('type','resource');
    }

    public function scopeActive($query)
    {
        return $query->where('status', true)->whereHas('video',fn($q) => $q->active());
    }

    public function ScopeDashboardTrainer($q)
    {
        if(auth()->user()->can('trainer_access') && !auth()->user()->can('dashboard_access')){
            return $q->whereHas('course',fn($q) => $q->DashboardTrainer());
        }

        return $q;
    }
}
