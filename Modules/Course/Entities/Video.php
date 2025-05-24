<?php

namespace Modules\Course\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\ScopesTrait;
use Modules\Course\Repositories\Dashboard\CourseVideoApiRepository;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Video extends Model implements HasMedia
{
    use ScopesTrait;
    use InteractsWithMedia;



    protected $fillable = ['thumb', 'video_link', 'video_length', 'status', 'loading_status'];

    public $appends = ['video_minutes'];
    public function scopeActive($query)
    {
        return $query->where('status', true)->where(function ($q) {
            $q->where('loading_status', 'loaded');
        });
    }

    public function credential()
    {
        return $this->hasOne(
            ObtainCredential::class,
            'api_video_id',
            'video_link',
        );
    }

    public function getVideoStatusAttribute()
    {
        return $this->credential?->status;
    }


    public function videoable()
    {
        return $this->morphTo();
    }


    public function getVideoMinutesAttribute()
    {
        $init = $this->video_length;
        $hours = floor($init / 3600);
        $minutes = floor(($init / 60) % 60);
        $seconds = $init % 60;

        return "$hours:$minutes:$seconds";
    }

    public function buildVideo()
    {
        return (new CourseVideoApiRepository())->buildVideo($this->video_link);
    }

    public function scopeactiveToShow($query)
    {
        return $query->where('loading_status','loaded');
    }
}
