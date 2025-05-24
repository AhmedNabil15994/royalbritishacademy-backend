<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use IlluminateAgnostic\Collection\Support\Carbon;
use Modules\Core\Traits\ScopesTrait;
use Modules\Course\Entities\Course;

class Order extends Model
{
    use SoftDeletes ;
    use ScopesTrait;

    protected $fillable = [
        'total',
        'unread',
        'subtotal',
        'discount',
        'user_id',
        'address_id',
        'is_holding',
        'order_status_id',
        'period',
    ];

    public function user()
    {
        return $this->belongsTo(\Modules\User\Entities\User::class);
    }

    public function orderStatus()
    {
        return $this->belongsTo(OrderStatus::class);
    }

    public function orderCourses()
    {
        return $this->hasMany(OrderCourse::class);
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class,'order_courses')->withPivot('total');
    }

    public function orderNotes()
    {
        return $this->hasMany(NoteOrder::class,'order_id');
    }

    public function orderPackages()
    {
        return $this->hasMany(OrderPackage::class);
    }

    public function coupon()
    {
        return $this->hasOne(OrderCoupon::class, 'order_id');
    }

    public function scopeUserAccess($query, $userId, $pivot_table = 'order_courses')
    {
        return $query->where(function ($q) use($userId, $pivot_table){

            $q->where(['orders.user_id' => $userId]);
            $q->whereHas('orderStatus', fn($q) => $q->successPayment());

            if(!in_array($pivot_table,['note_order']))
                $q->where(fn($q) => $q->whereDate("{$pivot_table}.expired_date", '>', Carbon::now()->toDateString())->orWhereNull("{$pivot_table}.expired_date"));

        });
    }
}
