<?php

namespace Modules\User\Entities;

use Illuminate\Support\Carbon;
use Modules\Authorization\Entities\ModelHasRole;
use Modules\Course\Entities\Course;
use Modules\Course\Entities\Note;
use Modules\Exam\Entities\UserExam;
use Modules\Order\Entities\Address;
use Modules\Order\Entities\NoteOrder;
use Modules\Order\Entities\Order;
use Modules\Package\Entities\Package;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Support\Facades\Hash;
use Modules\Core\Traits\ScopesTrait;
use Spatie\Permission\Traits\HasRoles;
use Modules\Order\Entities\OrderCourse;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\InteractsWithMedia;
use Modules\Core\Traits\Dashboard\CrudModel;
use Modules\DeviceToken\Traits\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Spatie\Permission\PermissionRegistrar;

class User extends Authenticatable implements HasMedia
{
    use CrudModel{
        __construct as private CrudConstruct;
    }

    use Notifiable , HasRoles , InteractsWithMedia,HasApiTokens;

    use SoftDeletes {
      restore as private restoreB;
    }
    protected $guard_name = 'web';
    protected $dates = [
      'deleted_at'
    ];

    protected $fillable = [
        'name', 'email', 'password', 'mobile' , 'image','academic_year_id'
    ];


    protected $hidden = [
        'password', 'remember_token',
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->setLogAttributes(['name', 'email', 'password', 'mobile' , 'image']);

    }

    public function setImageAttribute($value)
    {
        if (!$value) {
            $this->attributes['image'] = '/uploads/users/user.png';
        }
        $this->attributes['image'] = $value;
    }


      public function setPasswordAttribute($value)
    {
        if ($value === null || !is_string($value)) {
            return;
        }
        $this->attributes['password'] = Hash::needsRehash($value) ? Hash::make($value) : $value;
    }

    public function customRoles()
    {
        return $this->hasMany(ModelHasRole::class,'model_id');
    }

    public function restore()
    {
        $this->restoreB();
    }


    public function favouriteCourses()
    {
        return $this->belongsToMany(Course::class);
    }


    public function orderCourses(): HasManyThrough
    {
        return $this->hasManyThrough(OrderCourse::class, Order::class);
    }

    public function orderNotes(): HasManyThrough
    {
        return $this->hasManyThrough(NoteOrder::class, Order::class);
    }


    public function address()
    {
        return $this->hasOne(Address::class, 'user_id');
    }


    public function userExams()
    {
        return $this->hasMany(UserExam::class, 'user_id');
    }

    public function fcmTokens()
    {
        return $this->hasMany(FirebaseToken::class);
    }

    public function getMyCoursesAttribute()
    {
        return Course::with(['categories'])
        ->where(fn ($q) => $q->whereHas('orders', fn ($q) => $q->UserAccess($this->id)))
            ->join('order_courses', 'order_courses.course_id', '=', 'courses.id')
            ->groupBy('courses.id')
            ->orderBy('order_courses.created_at', 'DESC')
            ->select('courses.*');
    }

    public function getMyNotesAttribute()
    {
        $packageNotes = [];
        $packages = Package::where(fn($q) => $q->whereHas('orders', fn($q) => $q->UserAccess($this->id, 'order_package')))->pluck('settings')->toArray();

        $nestedPackagesIds = array_map(function($element){
            if(isset($element['notes']) && count($element['notes'])){
                return $element['notes'];
            }
        }, $packages);

        foreach($nestedPackagesIds as $ids){
            if($ids)
                $packageNotes = array_merge($packageNotes,$ids);
        }

        return Note::where(fn ($q) => $q->whereHas('orders', fn ($q) => $q->UserAccess($this->id, 'note_order')))
        ->orWhereIn('id', $packageNotes);
    }

    public function getMyPackagesAttribute()
    {
        return Package::where(fn($q) => $q->whereHas('orders', fn($q) => $q->UserAccess($this->id, 'order_package')));
    }

}
