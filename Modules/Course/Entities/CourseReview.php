<?php

namespace Modules\Course\Entities;

use Modules\User\Entities\User;
use Modules\Core\Traits\ScopesTrait;
use Illuminate\Database\Eloquent\Model;

class CourseReview extends Model
{
    use ScopesTrait;

    protected $fillable=[ 'course_id', 'user_id', 'stars', 'desc','status','in_slider'];


    public function reviewQuestionAnswer()
    {
        return $this->hasMany(ReviewQuestionAnswer::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
