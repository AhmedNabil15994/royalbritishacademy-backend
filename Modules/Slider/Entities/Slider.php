<?php

namespace Modules\Slider\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\HasTranslations;
use Modules\Core\Traits\ScopesTrait;
use Modules\Course\Entities\Course;
use Modules\Projects\Entities\Project;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Slider extends Model implements HasMedia
{
    use SoftDeletes ;
    use ScopesTrait ;
    use InteractsWithMedia;
    use HasTranslations;

    protected $dates = ['start_date', 'end_date'];
    protected $fillable = [
        'title',
        'description',
        'type',
        'order',
        'start_date',
        'end_date',
        'link',
        'course_id',

        'status',
    ];
    public $translatable  = [ 'title','description' ];



    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function getUrlAttribute()
    {
        switch ($this->type) {
            case 'link':
                return $this->link;
            case 'course' :
                return route('frontend.courses.show', optional($this->course)->slug);
            default:
                return '#';
        }
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function scopePublished($query)
    {
        return $query->where(function ($q) {
            $q->where(function ($q) {
                $q->whereDate('start_date', '<=', Carbon::now())
                    ->orWhereNull('start_date');
            })->where(function ($q) {
                $q->whereDate('end_date', '>=', Carbon::now())
                    ->orWhereNull('end_date');
            });
        });
    }
}
