<?php

namespace Modules\Exam\Entities;

use Modules\Core\Traits\ScopesTrait;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\HasTranslations;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Question extends Model implements HasMedia
{
    use HasTranslations ;
    use SoftDeletes ;
    use ScopesTrait;
    use InteractsWithMedia;
    protected $fillable  = ['question','exam_id','type'];
    public $translatable  = ['question'];

    public function answers()
    {
        return $this->hasMany(QuestionAnswer::class);
    }
}
