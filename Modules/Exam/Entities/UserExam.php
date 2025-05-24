<?php

namespace Modules\Exam\Entities;

use Modules\User\Entities\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserExam extends Model
{
    protected $guarded = [];
    protected $appends = ['result_percentage','exam_is_running'];

    /**
     * Get the user that owns the UserExam
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    /**
     * Get the exam that owns the UserExam
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function userExamAnswers(): HasMany
    {
        return $this->hasMany(UserExamAnswer::class);
    }


    /**
     * Get the exam that owns the UserExam
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function exam(): BelongsTo
    {
        return $this->belongsTo(Exam::class);
    }



    public function getResultPercentageAttribute()
    {
        return  $this->exam_degree ? $this->exam_result*100/$this->exam_degree : 0;
    }


    public function getExamIsRunningAttribute()
    {
        $examNotFinished=$this->created_at->addMinutes($this->exam->duration)->gt(now());
        if ($examNotFinished) {
            return  $this->created_at->addMinutes($this->exam->duration)->getPreciseTimestamp(3);
        }

        return $examNotFinished;
    }
}
