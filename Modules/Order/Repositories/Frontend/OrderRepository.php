<?php

namespace Modules\Order\Repositories\Frontend;

use Auth;
use CartTrait;
use Carbon\Carbon;
use Modules\Coupon\Http\Controllers\Frontend\CouponController;
use Modules\Course\Entities\Note;
use Modules\Order\Entities\Order;
use Illuminate\Support\Facades\DB;
use Modules\Course\Entities\Course;
use Modules\Course\Notifications\NewCourseEnrollmentNotification;
use Modules\Order\Entities\OrderCoupon;
use Modules\Order\Entities\OrderCourse;
use Modules\Order\Entities\OrderStatus;
use Modules\Order\Traits\OrderCalculationTrait;
use Modules\Package\Entities\PackagePrice;

class OrderRepository
{
    use OrderCalculationTrait;

    public function __construct(Order $order, OrderStatus $status, Course $course, OrderCoupon $orderCoupon)
    {
        $this->course = $course;
        $this->order = $order;
        $this->status = $status;
        $this->orderCoupon = $orderCoupon;
    }

    public function getAllByUser()
    {
        return $this->order->where('user_id', auth()->id())->get();
    }

    public function findById($id)
    {
        return $this->order->where('id', $id)->first();
    }


    public function createOrderEvent($event, $status = true)
    {
        DB::beginTransaction();

        try {
            $status = $this->statusOfOrder(false);

            $order = $this->order->create([
                'is_holding' => true,
                'discount' => 0.000,
                'subtotal' => $event['price'],
                'total' => $event['price'],
                'user_id' => auth()->id(),
                'order_status_id' => $status->id,
            ]);


            $this->orderEvent($order, $event);

            DB::commit();
            return $order;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function create($request, $status = true)
    {

        try {
            DB::beginTransaction();

            $data = $this->calculateTheOrder($request);
            $status = $this->statusOfOrder(false);

            if (!$data) {
                return false;
            }

            $order = $this->order->create([
                'is_holding' => true,
                'discount' => isset($data['coupon']['discount_value']) ? $data['coupon']['discount_value'] : 0.000,
                'total' => $data['total'],
                'subtotal' => $data['subtotal'],
                'user_id' => $request->user_id,
                'order_status_id' => $status->id,
            ]);

            $this->orderCourses($order, $data);
            $this->orderNotes($order, $data);
            $this->orderPackages($order, $data);
            if ($data['coupon']) {
                $this->OrderCoupon($order, $data);
            }

            DB::commit();
            return $order;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function BuySingleCourse($request, $course)
    {
        DB::beginTransaction();

        try {
            $status = $this->statusOfOrder(true);

            $order = $this->order->create([
                'is_holding' => true,
                'discount' => 0.000,
                'subtotal' => $course->price,
                'total' => $course->price,
                'user_id' => auth()->user()->id,
                'order_status_id' => $status->id,
            ]);

            $order->orderCourses()->create([
                'course_id'    => $course->id,
                'total'        => $course->price,
                'trainer_id'   => $course->trainer_id,
                'user_id'      => auth()->user()->id,
                'expired_date' => $course->expire_after ? Carbon::now()->addDays($course->expire_after)->toDateString() : null,
            ]);
            DB::commit();
            return $order;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function orderCourses($order, $data)
    {
        foreach ($data['order_courses'] as $key => $orderCourse) {

            $course = $orderCourse['course'];
            $order->orderCourses()->create([
                'course_id'    => $course->id,
                'total'        => $orderCourse['subtotal'],
                'trainer_id'   => $course->trainer_id,
                'user_id'      => auth()->user()->id,
                'expired_date' => $course->expire_after ? Carbon::now()->addDays($course->expire_after)->toDateString() : null,
            ]);
        }
    }

    public function OrderCoupon($order, $data)
    {
        $this->orderCoupon->create([
            'order_id'    => $order->id,
            'coupon_id'        => $data['coupon']['id'],
            'user_id'        => $order->user_id,
            'code'   => $data['coupon']['code'],
            'discount_type'      => $data['coupon']['type'],
            'discount_percentage'      => $data['coupon']['discount_percentage'],
            'discount_value'      => $data['coupon']['discount_value'],
        ]);
    }

    public function orderNotes($order, $data)
    {
        foreach ($data['order_notes'] as $orderNote) {
            $note = $orderNote['note'];

            $order->orderNotes()->create([
                'note_id'    => $note->id,
                'total'    => $orderNote['total'],
                'trainer_id'   => $note->trainer_id,
            ]);
        }
    }

    public function orderPackages($order, $data)
    {
        foreach ($data['order_packages'] as $orderPackage) {
            $packagePrice = $orderPackage['package'];
            $package = $packagePrice->package;

            $order->orderPackages()->create([
                'package_id'    => $package->id,
                'has_offer'    => $orderPackage['off'] ? true : false,
                'offer_price'    => $orderPackage['off'],
                'total'    => $orderPackage['total'],
                'period'    => $packagePrice->days_count,
                'settings'    => $package->settings,
            ]);
        }
    }


    public function orderEvent($order, $event)
    {
        $orderCourse = $order->orderCourses()->create([
            'course_id' => $event['id'],
            'total' => $event['price'],
        ]);
    }

    public function update($id, $boolean)
    {
        $order = $this->findById($id);

        $status = $this->statusOfOrder($boolean);

        $order->update([
            'is_hold' => false,
            'order_status_id' => $status['id']
        ]);

        $this->updateCoursePeriod($order);
        $this->updatePackagePeriod($order);

        return $order;
    }

    private function updateCoursePeriod($order): void
    {
        foreach ($order->orderCourses()->get() as $orderCourse) {
            $course = $orderCourse->course;

            if ($course->period) :
                $orderCourse->update([
                    'period' => $course->period,
                    'expired_date' => Carbon::now()->addDays($course->period)->toDateTimeString(),
                ]);
            endif;

            $this->notify($orderCourse);
        }
    }

    private function updatePackagePeriod($order): void
    {
        foreach ($order->orderPackages()->get() as $orderPackage) {
            $orderPackage->update([
                'expired_date' => Carbon::now()->addDays($orderPackage->period)->toDateTimeString(),
            ]);
        }
    }

    public function statusOfOrder($type)
    {
        if ($type) {
            $status = $this->status->successPayment()->first();
        }
        if (!$type) {
            $status = $this->status->failedOrderStatus()->first();
        }
        return $status;
    }


    private function notify(OrderCourse $orderCourse): void
    {
        // $orderCourse->user->notify(new NewCourseEnrollmentNotification($orderCourse->course));
    }
}
