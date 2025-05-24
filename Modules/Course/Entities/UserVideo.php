<?php

namespace Modules\Course\Entities;

use Illuminate\Database\Eloquent\Model;

class UserVideo extends Model
{
    protected $fillable = ['lesson_content_id', 'user_id', 'totalPlayed', 'watched'];


    public function setTotalPlayedAttribute($value)
    {
        if ($this->watched==1) {
            return;
        }
        $this->attributes['totalPlayed'] = $value;
    }
}
