<?php

namespace Modules\Trainer\Entities;

use Carbon\Carbon;
use Modules\Authorization\Entities\ModelHasRole;
use Modules\Blog\Entities\Blog;
use Illuminate\Support\Facades\DB;
use Modules\Course\Entities\Course;
use Illuminate\Support\Facades\Hash;
use Modules\Catalog\Entities\Client;
use Modules\Core\Traits\ScopesTrait;
use Spatie\Permission\Traits\HasRoles;
use Modules\Order\Entities\OrderCourse;
use Illuminate\Notifications\Notifiable;
use Modules\Course\Entities\CourseReview;
use Modules\Membership\Entities\Membership;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Trainer extends Authenticatable
{
    use Notifiable;
    use ScopesTrait;
    use HasRoles;
    use HasFactory;

    use SoftDeletes {
        restore as private restoreB;
      }

    protected $guard_name = 'web';
    protected $table = 'users';

    protected $dates = [
        'deleted_at'
    ];

    protected $fillable = [
        'name', 'email', 'password', 'mobile', 'image'
    ];



    protected $hidden = [
        'password', 'remember_token',
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function restore()
    {
        $this->restoreB();
    }

    public function profile()
    {
        return $this->hasOne(TrainerProfile::class);
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }


    public function customRoles()
    {
        return $this->hasMany(ModelHasRole::class,'model_id');
    }


    public function courseReviews()
    {
        return $this->hasManyThrough(CourseReview::class, Course::class);
    }


    // public function clients()
    // {
    //     return $this->hasMany(Client::class);
    // }

    public function sliders()
    {
        return $this->hasMany(TrainerSlider::class);
    }

    // public function blogs()
    // {
    //     return $this->hasMany(Blog::class);
    // }

    public function orderCourse()
    {
        return $this->hasMany(OrderCourse::class);
    }


    public function student()
    {
        return  $this->orderCourse()
          ->where('user_id', auth()->id())
            ->where(function ($q) {
                $q->whereNull('expired_date')->orWhere('expired_date', '>=', Carbon::now()->toDateTimeString());
            })->whereHas('order', function ($query) {
                $query->whereHas('orderStatus', function ($query) {
                    $query->successPayment();
                });
            })->count();
    }


    public function setPasswordAttribute($value)
    {
        if ($value === null || ! is_string($value)) {
            return;
        }
        $this->attributes['password'] = Hash::needsRehash($value) ? Hash::make($value) : $value;
    }



    protected static function booted()
    {
        static::addGlobalScope('withReviews', function ($query) {
            $query->withCount(['courseReviews as stars'=>function ($q) {
                $q->select(DB::raw('avg(course_reviews.stars) as stars'));
            }]);
        });
    }
}
