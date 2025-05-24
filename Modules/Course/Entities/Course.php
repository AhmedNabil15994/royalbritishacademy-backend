<?php

namespace Modules\Course\Entities;

use Carbon\Carbon;
use Modules\Category\Entities\Material;
use Modules\Order\Entities\Order;
use Modules\Package\Entities\Package;
use Modules\Package\Entities\PackagePrice;
use Modules\User\Entities\User;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Support\Facades\DB;
use Modules\Core\Traits\ScopesTrait;
use Illuminate\Database\Eloquent\Model;
use Modules\Category\Entities\Category;
use Modules\Order\Entities\OrderCourse;
use Modules\Core\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Course\Entities\CourseEnrollment;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Core\Traits\HasSlugTranslation;
use Spatie\SchemalessAttributes\Casts\SchemalessAttributes;
use Staudenmeir\EloquentJsonRelations\HasJsonRelationships;

class Course extends Model
{
    use HasTranslations;
    use SoftDeletes;
    use ScopesTrait;
    use HasSlugTranslation;

    use HasJsonRelationships, HasTranslations {
        HasJsonRelationships::getAttributeValue as getAttributeValueJson;
        HasTranslations::getAttributeValue as getAttributeValueTranslations;
    }
    protected $fillable = [
        'is_certificated',
        'price',
        'image',
        'class_time',
        'trainer_id',
        'period',
        'description',
        'intro_video',
        'title',
        'slug',
        'requirements',
        'level_id',
        'status',
        'short_desc',
        'order',
        'extra_attributes',
        'expire_after', // days number
    ];

    public $translatable  = ['description', 'title', 'slug', 'requirements', 'short_desc'];

    public $with = ['video'];
    public $sluggable    = 'title';
    public $casts = [
        'extra_attributes' => SchemalessAttributes::class,
    ];
    public function getAttributeValue($key)
    {
        if (!$this->isTranslatableAttribute($key)) {
            return $this->getAttributeValueJson($key);
        }
        return $this->getAttributeValueTranslations($key);
    }

    public function scopeWithExtraAttributes(): Builder
    {
        return $this->extra_attributes->modelScope();
    }

    public function orderCourse()
    {
        return $this->hasMany(OrderCourse::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class,'order_courses')->withPivot('expired_date');
    }

    public function reportOrders()
    {
        return $this->belongsToMany(Order::class,'order_courses')->withPivot('expired_date')->where(function($query){
            if (isset(request()->req['from']) && request()->req['from'] != '') {
                $query->whereDate('created_at', '>=', request()->req['from']);
            }

            if (isset(request()->req['to']) && request()->req['to'] != '') {
                $query->whereDate('created_at', '<=', request()->req['to']);
            }
        });
    }

    public function packages()
    {
        return $this->hasManyJson(Package::class, 'settings->courses');
    }

    public function lessons()
    {
        return $this->hasMany(LessonContent::class,'course_id');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'course_categories');
    }

    public function materials()
    {
        return $this->belongsToMany(Material::class, 'course_material');
    }


    public function trainer()
    {
        return $this->belongsTo(\Modules\Trainer\Entities\Trainer::class);
    }

    public function offer()
    {
        return $this->hasOne(CourseOffer::class, 'course_id');
    }

    public function activeOffer()
    {
        return $this->hasOne(CourseOffer::class, 'course_id')->Unexpired();
    }

    public function subscribed()
    {
        return $this->orderCourse()
            ->where('user_id', auth()->id())
            ->where(function ($q) {
                $q->whereNull('expired_date')->orWhere('expired_date', '>=', Carbon::now()->toDateTimeString());
            })->whereHas('order', function ($query) {
                $query->whereHas('orderStatus', function ($query) {
                    $query->successPayment();
                });
            });
    }

    public function subscriptions()
    {
        return $this->orderCourse()
            ->whereHas('order', function ($query) {
                $query->whereHas('orderStatus', function ($query) {
                    $query->successPayment();
                });
            });
    }


    public function getUserCompletePercentageAttribute()
    {
        $total_lessons = $this->lessons()->active()->count();
        $show_lessons = auth()->check() ? $this->lessons()->active()->whereHas('userCompletes',
            function ($q) {
                $q->where('user_id', auth()->user()->id);
            })->count() : 0;

        return number_format(($total_lessons ? ($show_lessons / $total_lessons) * 100 : 0), 1);
    }

    public function gallery()
    {
        return $this->hasMany(CourseImage::class);
    }

    public function video()
    {
        return $this->morphOne(Video::class, 'videoable');
    }


    /**
     * Get all of the targets for the Course
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function targets()
    {
        return $this->hasMany(CourseTarget::class);
    }
    /**
     * Get all of the courseReviews for the Course
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function courseReviews()
    {
        return $this->hasMany(CourseReview::class);
    }


    public function activeCourseReviews()
    {
        return $this->hasMany(CourseReview::class)->where('status', 1);
    }

    public function lessonContents()
    {
        return $this->hasManyThrough(LessonContent::class, Lesson::class);
    }
    public function isFinished()
    {
        return $this->orderCourse()
            ->where(['user_id' => auth()->id(), 'is_watched' => 1])
            ->whereHas('order', function ($query) {
                $query->whereHas('orderStatus', function ($query) {
                    $query->successPayment();
                });
            })->count();
    }

    public function getCurrentUserHasAccessAttribute()
    {
        if(getCurrentMokbileVersion()){

            return true;
        }

        if(auth()->check()){

            $checkOrderCourses = $this->orders()->where(fn ($q) => $q->UserAccess(auth()->user()->id))->count();
            return $checkOrderCourses ? true : false;
        }

        return false;
    }


    public function isReviewed()
    {
        return $this->courseReviews()->where(['user_id' => auth()->id()])->exists();
    }

    protected static function booted()
    {
        static::addGlobalScope('withReviews', function ($query) {
            $query->withCount(['courseReviews as stars' => function ($q) {
                $q->select(DB::raw('avg(course_reviews.stars) as stars'));
            }]);
        });
    }

    public function favouriteUsers()
    {
        return $this->belongsToMany(User::class);
    }

    public function getIsFavouriteAttribute()
    {
        return request()->user() && request()->user()->favouriteCourses()->find($this->id) ? true : false;
    }

    public function ScopeCategories($q, $categories)
    {
        return $q->whereHas(
            'categories',
            fn ($q) => $q->whereIn('course_categories.category_id', $categories)

        );
    }
    public function ScopeSubscribed($q, $user_id)
    {
        return $q
            ->withCount(
                [
                    'orderCourse as is_subscribed' => fn ($q) => $q->whereUserId($user_id)->notExpired()->successPay()
                ]
            );
    }



    public function ScopeTrainer($q, $trainerId)
    {
        return $q->whereTrainerId($trainerId);
    }

    public function ScopeDashboardTrainer($q)
    {
        if(auth()->user()->can('trainer_access') && ! auth()->user()->can('dashboard_access')){

            return $q->where('courses.trainer_id',auth()->id());
        }

        return $q;
    }

    public function ScopeSearch($q, $search)
    {
        return $q
            ->where(
                fn ($query) =>
                $query
                    ->Where("courses.title->" . locale(), 'like', '%' . $search . '%')
                    ->orWhere("courses.slug->" . locale(), 'like', '%' . $search . '%')
            );
    }

    public function course_lessons()
    {
        return $this->hasMany(Lesson::class,'course_id');
    }
}
