<?php

namespace Modules\Trainer\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\HasTranslations;
use Modules\Core\Traits\ScopesTrait;

class TrainerSlider extends Model
{
    use HasTranslations ;
    use ScopesTrait;

    protected $table              = 'trainer_sliders';
    protected $fillable = [
        'status' ,
        'trainer_id',
        'description',
    ];

    public $translatable 	= [ 'description' ];

    public function trainer()
    {
        return $this->belongsTo(Trainer::class);
    }
}
