<?php

namespace Modules\Course\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\User\Entities\User;

class UserComplation extends Model
{
   protected $table = 'user_completions';

   protected $fillable = ['lesson_content_id','user_id'];

   public function client()
   {
       return $this->belongsTo(User::class,'user_id');
   }

   public function lesson()
   {
       return $this->belongsTo(LessonContent::class,'lesson_content_id');
   }
}