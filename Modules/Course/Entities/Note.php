<?php

namespace Modules\Course\Entities;


use Modules\Core\Traits\ScopesTrait;
use Illuminate\Database\Eloquent\Model;
use Modules\Category\Entities\Category;
use Modules\Core\Traits\HasTranslations;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Order\Entities\Order;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Note extends Model  implements HasMedia
{
    use HasTranslations;
    use SoftDeletes;
    use InteractsWithMedia;
    use ScopesTrait;

    protected $guarded = ['id'];

    public $translatable  = ['title', 'desc'];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function trainer()
    {
        return $this->belongsTo(\Modules\Trainer\Entities\Trainer::class);
    }
    public function getImageAttribute()
    {
        return $this->getFirstMediaUrl('images') != "" ? $this->getFirstMediaUrl('images') : asset(setting('logo'));
    }
    public function ScopeTrainer($q, $trainerId)
    {
        return $q->whereTrainerId($trainerId);
    }
    public function ScopeSearch($q, $search)
    {
        return $q->where(
            fn ($query) => $query->Where("title->" . locale(), 'like', '%' . $search . '%')
        );
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class,'note_order');
    }
}
