<?php

namespace Modules\Course\Entities;

use Modules\Core\Traits\ScopesTrait;
use Illuminate\Database\Eloquent\Model;
use Modules\Semester\Entities\Semester;
use Modules\Core\Traits\HasTranslations;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lesson extends Model
{
    use HasTranslations;
    use ScopesTrait;
    use SoftDeletes;

    protected $fillable = ['course_id', 'status', 'image', 'title', 'semester_id','order'];
    public $translatable  = ['title'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }

    public function lessonContents()
    {
        return $this->hasMany(LessonContent::class)->oldest('order');
    }

    public function scopesemesterId($query,$id)
    {
        return $query->where('semester_id',$id);
    }
}
