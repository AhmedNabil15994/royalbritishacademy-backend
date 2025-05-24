<?php

namespace Modules\Exam\Entities;

use Modules\Core\Traits\ScopesTrait;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\HasTranslations;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuestionAnswer extends Model
{
    use HasTranslations ;
    use SoftDeletes ;
    use ScopesTrait;

    protected $fillable   = ['question_id','degree','answer'];
    public $translatable  = ['answer'];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
