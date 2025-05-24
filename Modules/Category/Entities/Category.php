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

class Category extends Model implements HasMedia
{
    use CrudModel, SoftDeletes, InteractsWithMedia;
    use HasJsonRelationships, HasTranslations {
        HasJsonRelationships::getAttributeValue as getAttributeValueJson;
        HasTranslations::getAttributeValue as getAttributeValueTranslations;
    }
    
    public function getAttributeValue($key)
    {
        if (!$this->isTranslatableAttribute($key)) {
            return $this->getAttributeValueJson($key);
        }
        return $this->getAttributeValueTranslations($key);
    }
    protected $fillable = ['status', 'type', 'category_id', 'title','color','order'];
    public $translatable = ['title'];

    public function parent()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }


    public function packages()
    {
        return $this->hasMany(Package::class, 'settings->category_id');
    }

    public function packagePrices()
    {
        return $this->hasManyThrough(PackagePrice::class,Package::class, 'settings->category_id','package_id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'options->locale_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'category_id');
    }
    /**
     * Get all of the notes for the Category
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function notes(): HasMany
    {
        return $this->hasMany(Note::class);
    }
    /**
     * The roles that belong to the Category
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'course_categories');
    }


    public function getParentsAttribute()
    {
        $parents = collect([]);
        $parent = $this->parent;
        while (!is_null($parent)) {
            $parents->push($parent);
            $parent = $parent->parent;
        }
        return $parents;
    }


    public function scopeMainCategories($query)
    {
        return $query->where('category_id', '=', null);
    }
}
