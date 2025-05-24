<?php

namespace Modules\Course\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\ScopesTrait;

class CourseOffer extends Model
{
    use ScopesTrait;

    protected $fillable = ['course_id', 'start_at', 'end_at', 'offer_price', 'status', 'percentage'];

    public function scopeUnexpired($query)
    {
        return $query->where('start_at', '<=', date('Y-m-d'))->where('end_at', '>', date('Y-m-d'));
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

}
