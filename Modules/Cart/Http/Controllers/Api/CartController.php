<?php

namespace Modules\Cart\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Apps\Http\Controllers\Api\ApiController;
use Modules\Cart\Traits\CartTrait;
use Modules\Cart\Http\Requests\Api\CartRequest;
use Modules\Cart\Transformers\Api\CartResource;
use Modules\Coupon\Entities\Coupon;
use Modules\Coupon\Http\Requests\WebService\CouponRequest;
use Modules\Course\Transformers\Api\CourseResource;
use Modules\Course\Transformers\Frontend\NoteResource;
use Modules\Package\Transformers\Frontend\CartPackageResource;
use Modules\Course\Repositories\Frontend\CourseRepository as Course;
use Modules\Course\Repositories\Frontend\NoteRepository as Note;
use Modules\Package\Repositories\Frontend\PackageRepository as Package;

class CartController extends ApiController
{
    use CartTrait;

    protected $course;
    protected $note;
    protected $package;

    public function __construct(Course $course,Note $note,Package $package)
    {
        $this->course = $course;
        $this->note = $note;
        $this->package = $package;
    }

    public function index(Request $request)
    {
        $coursesSubscribed = $this->course->subscribedCourses();
        foreach ($coursesSubscribed as $course) {
            $this->removeItem($course['id'], 'course');
        }

        return $this->cartResponse();
    }

    public function add(CartRequest $request, $id)
    {
        $type = 'course';
        $item = $this->getItem($id, $type);
        if (is_null($item)) {
            return $this->error('course not found');
        }
        $this->addToCart($item, $type, $request->qty);
        return $this->cartResponse();
    }

    private function cartResponse()
    {
        $items = array_values($this->getCartContent()->toArray());

        return $this->response([
            'items' => CartResource::collection($items),
            'conditions' => $this->getCartConditions(),
            'subTotal' => $this->cartSubTotal(),
            'total' => $this->cartSubTotal(),
            'count' => $this->cartCount(),
        ]);
    }

    public function removeCoupon()
    {
        $this->removeCouponConditionByName();
        return $this->cartResponse();
    }

    private function  getItem($id, $type)
    {
        try {
            switch($type){
                case 'note':
                    $model = $this->note->findNoteById($id);
                    $item = !is_null($model) ? (new NoteResource($model))->jsonSerialize() : null;
                    break;
                case 'course':
                    $model = $this->course->findCourseById($id);
                    $item = !is_null($model) ? (new CourseResource($model))->jsonSerialize() : null;
                    break;
                case 'package':
                    $model = $this->package->findPackageById($id);
                    $item = !is_null($model) ? (new CartPackageResource($model))->jsonSerialize() : null;
                    break;
            }

            return $item;
        } catch (\Throwable $th) {
            return redirect()->back();
        }
    }
    public function remove(CartRequest $request, $id)
    {
        $type = 'course';
        $this->removeItem($id, $type);

        return $this->cartResponse();
    }

    public function clear()
    {
        $this->removeCouponConditionByName();
        $this->getCart()->clear();

        return $this->response([]);
    }


    public function addCoupon(CouponRequest $request)
    {
        $this->removeCouponConditionByName();
        $coupon = Coupon::where('code', $request->code)->where(function($query){
            $query->where(function($query){

                $query->where('start_at', '<=', date('Y-m-d'));
                $query->where('expired_at', '>', date('Y-m-d'));
            });
            $query->orWhere(function($query){

                $query->whereNull('start_at');
                $query->where('expired_at', '>', date('Y-m-d'));
            });
            $query->orWhere(function($query){

                $query->where('start_at', '<=', date('Y-m-d'));
                $query->whereNull('expired_at');
            });
            $query->orWhere(function($query){

                $query->whereNull('start_at');
                $query->whereNull('expired_at');
            });
        })->active()->first();

        if ($coupon) {
            $is_valid = $coupon->user_max_uses ? ( $coupon->orders->where('user_id', $request->user_token)->count() >= $coupon->user_max_uses ? false : true ) : true;
            if (!$is_valid) {
                return $this->error(__('coupon::frontend.coupons.validation.code.not_found'));
            }
            $discount_value = 0;
            if ($coupon->discount_type == "value")
                $discount_value = $coupon->discount_value;
            elseif ($coupon->discount_type == "percentage")
                $discount_value = ($this->getCart()->getSubTotal() * $coupon->discount_percentage) / 100;

            $resultCheck = $this->discountCouponCondition($coupon, $discount_value);
            if (!$resultCheck)
                return $this->error(__('coupon::api.coupons.validation.condition_error'));

            $data = [
                'discount_value' => number_format($discount_value,3),
                'subTotal' => $this->cartSubTotal(),
                'total' => $this->cartSubTotal(),
            ];

            return $this->response($data);

        } else {
            return $this->error(__('coupon::frontend.coupons.validation.code.not_found'));
        }
    }
}
