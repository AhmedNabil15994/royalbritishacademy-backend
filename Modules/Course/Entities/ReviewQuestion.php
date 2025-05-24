<?php

namespace Modules\Course\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Core\Traits\ScopesTrait;
use Modules\User\Entities\User;

class ReviewQuestion extends Model
{
    use ScopesTrait;
    use SoftDeletes;

    protected $fillable = ['title', 'status','course_id','user_id','question'];


    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function answers()
    {
        return $this->hasMany(ReviewQuestionAnswer::class);
    }
}
