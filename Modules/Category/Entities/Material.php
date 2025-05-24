<?php

namespace Modules\Category\Entities;

use Modules\Course\Entities\Note;
use Modules\Package\Entities\PackagePrice;
use Spatie\MediaLibrary\HasMedia;
use Modules\Course\Entities\Course;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\HasTranslations;
use Spatie\MediaLibrary\InteractsWithMedia;
use Modules\Core\Traits\Dashboard\CrudModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\Package\Entities\Package;
use Staudenmeir\EloquentJsonRelations\HasJsonRelationships;

class Material extends Model implements HasMedia
{
    use CrudModel, SoftDeletes, InteractsWithMedia;
    use HasTranslations;
    protected $fillable = ['status', 'title','sort'];
    public $translatable = ['title'];


    public function users()
    {
        return $this->hasMany(User::class, 'options->locale_id');
    }

    /**
     * The roles that belong to the Category
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'course_material');
    }
}
