<?php

namespace Modules\Course\Entities;

use Illuminate\Database\Eloquent\Model;

class CourseImage extends Model
{
    protected $fillable = [ 'course_id' , 'image' ];
}
