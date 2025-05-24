<?php

namespace Modules\Course\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\ScopesTrait;
use Modules\User\Entities\User;

class ReviewQuestionAnswer extends Model
{
    use ScopesTrait;
    protected $fillable = ['course_review_id', 'review_question_id', 'answer','user_id'];



    public function review()
    {
        return $this->belongsTo(CourseReview::class);
    }

    public function reviewQuestion()
    {
        return $this->belongsTo(ReviewQuestion::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
