<?php

namespace Modules\Package\Entities;

use Carbon\Carbon;
use Modules\Course\Entities\Note;
use Modules\Order\Entities\Order;
use Spatie\MediaLibrary\HasMedia;
use Modules\Course\Entities\Course;
use Modules\Core\Traits\CoreHelpers;
use Illuminate\Database\Eloquent\Model;
use Modules\Category\Entities\Category;
use Modules\Core\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Builder;
use Spatie\MediaLibrary\InteractsWithMedia;
use Modules\Core\Traits\Dashboard\CrudModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\SchemalessAttributes\Casts\SchemalessAttributes;
use Staudenmeir\EloquentJsonRelations\HasJsonRelationships;

class Package extends Model implements HasMedia
{
    use CrudModel;
    use SoftDeletes;

    use InteractsWithMedia;
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

    // use CoreHelpers;
    protected $guarded = ["id"];
    public $translatable = ['title', 'description'];

    public $casts = [
        'settings' => SchemalessAttributes::class,
    ];
    public function scopeWithSettings(): Builder
    {
        return $this->settings->modelScope();
    }
    public function prices()
    {
        return $this->hasMany(PackagePrice::class, "package_id");
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class, "package_id");
    }

    public function toDaySubscriptions()
    {
        return $this->hasMany(Subscription::class, "package_id")->ToDay();
    }

    public function courses()
    {
        return $this->belongsToJson(Course::class, 'settings->courses');
    }
    public function category()
    {
        return $this->belongsTo(Category::class, 'settings->category_id');
    }
    public function notes()
    {
        return $this->belongsToJson(Note::class, 'settings->notes');
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class)->withPivot('expired_date');
    }




    public function createSubscriptions($user_id, $price, $coupon_data, $from_admin = false, $attribute = [])
    {
        $data = [
            "from_admin" => $from_admin,
            "paid" => $from_admin == false ? 'pending' : 'paid',
            "price" => $price->active_price['price'],
            "same_pricerenew_times" => $price->same_pricerenew_times,
            "max_puse_days" => $price->max_puse_days,
            "package_price_id" => $price->id,
            "start_at" => Carbon::parse($attribute['start_at']),
            "is_free" => $price->active_price['price'] <= 0,
            "user_id" => $user_id,
            "is_default" => $price->active_price['price'] <= 0 ? true : false,
        ];
        $data['end_at'] = $this->calculateEndAt($data['start_at'], $price->days_count);
        $data = array_merge($data, $attribute);
        $subscription = $this->subscriptions()->create($data);

        if ($coupon_data && $coupon_data[0]) {
            $coupon = $coupon_data[2];
            $subscription->coupon()->create([
                'coupon_id' => $coupon->id,
                'code' => $coupon->code,
                'discount_type' => $coupon->discount_type,
                'discount_percentage' => $coupon->discount_percentage,
                'discount_value' => $coupon->discount_value
            ]);
        }
        if ($price->active_price['price'] <= 0) {
            Subscription::where("user_id", $user_id)
                ->where("id", "!=", $subscription->id)
                ->update(["is_default" => false]);
        }
        return $subscription;
    }




    public function ScopeCategories($q, $categories)
    {
        return $q->whereHas(
            'categories',
            fn ($q) => $q->whereIn('categorized.category_id', $categories)

        );
    }
    public function getImageAttribute()
    {
        return $this->getFirstMediaUrl('images') != "" ? $this->getFirstMediaUrl('images') : asset(setting('logo'));
    }
    
    public function ScopeSearch($q, $search)
    {
        return $q
            ->where(
                fn ($query) =>
                $query
                    ->Where("title->" . locale(), 'like', '%' . $search . '%')
            );
    }

}
