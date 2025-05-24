<?php

namespace Modules\Course\Entities;

use Modules\Core\Traits\ScopesTrait;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\HasTranslations;

class CourseTarget extends Model
{
    use HasTranslations;
    use ScopesTrait;

    protected $fillable = [
        'course_id',
        'target',
    ];

    public $translatable  = ['target'];
}
