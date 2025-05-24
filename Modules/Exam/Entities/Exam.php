<?php

namespace Modules\Exam\Entities;

use Modules\Core\Traits\ScopesTrait;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\HasTranslations;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Course\Entities\LessonContent;

class Exam extends Model
{
    use HasTranslations;
    use ScopesTrait;
    use SoftDeletes;
    public $fillable = ["title","degree","success_degree","duration"];
    public $translatable = ["title"];


    /**
     * Get all of the questions for the Exam
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    /**
     * Get all of the questions for the Exam
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function lessonContents(): HasMany
    {
        return $this->hasMany(LessonContent::class,'exam_id')->where('type','exam');
    }
}
