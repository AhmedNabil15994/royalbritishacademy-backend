<?php

namespace Modules\Trainer\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\HasTranslations;
use Modules\Core\Traits\ScopesTrait;

class TrainerProfile extends Model
{
    use HasTranslations ;
    use ScopesTrait;

    protected $table = 'trainer_profile';
    protected $fillable = [
        'facebook' ,
        'linkedin' ,
        'twitter' ,
        'instagram' ,
        'youtube',
        'status' ,
        'trainer_id',
        'about',
        'job_title',
        'country',
    ];

    public $translatable 	= [ 'about' , 'job_title' , 'country'];
}
