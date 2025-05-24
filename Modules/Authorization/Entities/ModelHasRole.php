<?php

namespace Modules\Authorization\Entities;

use Illuminate\Database\Eloquent\Model;

class ModelHasRole extends Model
{
    protected $table = 'model_has_roles';


    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
