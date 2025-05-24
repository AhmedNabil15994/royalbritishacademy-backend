<?php

namespace Modules\Trainer\Entities;

use Spatie\MediaLibrary\HasMedia;
use Modules\Trainer\Entities\Trainer;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Apply extends Model implements HasMedia
{
    use InteractsWithMedia;
    protected $guarded = [];
}
