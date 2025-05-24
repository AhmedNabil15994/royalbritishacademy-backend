<?php

namespace Modules\Semester\Entities;

use Spatie\Sluggable\SlugOptions;
use Modules\Core\Traits\ScopesTrait;
use Modules\Trainer\Entities\Trainer;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\HasTranslations;
use Modules\Core\Traits\HasSlugTranslation;
use Illuminate\Database\Eloquent\SoftDeletes;

class Semester extends Model
{
    use HasTranslations;
    use ScopesTrait;
    use SoftDeletes;

    protected $guarded = ['id'];
    public $translatable = ['title'];

}
