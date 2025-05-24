<?php

namespace Modules\Order\Traits;

use Modules\Cart\Traits\CartTrait;
use Modules\Course\Entities\Course;
use Modules\Course\Entities\Note;
use Modules\Package\Entities\Package;
use Modules\Package\Entities\PackagePrice;

trait OrderCalculationTrait
{
    use CartTrait;

    public function calculateTheOrder($request)
    {
        $cart = $this->getCartContent();

        $subtotal = 0.000;
        $total = 0.000;

        $courses = [];
        $notes = [];
        $coupon = [];
        $packages = [];
        $discount = 0;
        $checkValue = null;
        $couponCondition = $this->getConditionByName('coupon_discount');
        if (!is_null($couponCondition)) {
            $coupon['id'] = $couponCondition->getAttributes()['coupon']['id'];
            $coupon['code'] = $couponCondition->getAttributes()['coupon']['code'];
            $coupon['type'] = $couponCondition->getAttributes()['coupon']['discount_type'];
            $coupon['discount_value'] = abs($couponCondition->getAttributes()['coupon']['discount_value'] ?? $couponCondition->getValue());
            $coupon['discount_percentage'] = $couponCondition->getAttributes()['coupon']['discount_percentage'];
            $discount = $coupon['discount_value'];
            $subtotal -= $coupon['discount_value'];
            $checkValue = $coupon['discount_percentage'];
        } else {
            $coupon = null;
        }
        $itemsCount = count($cart);

        foreach ($cart as $key => $item) {
            switch($item['attributes']['type']){
                case 'course':
                    $orderCourses['course'] = Course::find($item['attributes']['item_id']);
                    $orderCourses['price'] = $orderCourses['course']['price'];
                    $orderCourses['total'] = $item['price'];
                    $orderCourses['subtotal'] = $item['price'] - (
                        $checkValue ? round( $item['price'] * ($checkValue/100) ,3) : round($discount/$itemsCount , 3)
                    );
                    $subtotal += $orderCourses['total'];
                    $total += $orderCourses['total'];
                    $courses[] = $orderCourses;
                    break;
                case 'note':
                    $orderNotes['note'] = Note::find($item['attributes']['item_id']);
                    $orderNotes['price'] = $orderNotes['note']['price'];
                    $orderNotes['total'] = $item['price'];

                    $subtotal += $orderNotes['total'];
                    $total += $orderNotes['total'];
                    $notes[] = $orderNotes;
                    break;
                case 'package':
                    $orderPackages['package'] = PackagePrice::find($item['attributes']['item_id']);

                    $orderPackages['price'] = $orderPackages['package']->has_offer_know ?
                        calculateOfferAmountByPercentage($orderPackages['package']->price,$orderPackages['package']->offer_percentage) :
                        $orderPackages['package']->price;

                    $orderPackages['off'] =
                        $orderPackages['package']->has_offer_know ?
                        $orderPackages['package']->price - calculateOfferAmountByPercentage($orderPackages['package']->price, $orderPackages['package']->offer_percentage)
                         : null;

                    $orderPackages['total'] = $orderPackages['price'];

                    $subtotal += $orderPackages['total'];
                    $total += $orderPackages['total'];
                    $packages[] = $orderPackages;
                    break;

            }
        }



        return [
            'subtotal' => $subtotal,
            'total' => $total,
            'coupon' => $coupon,
            'order_courses' => $courses,
            'order_notes' => $notes,
            'order_packages' => $packages,
        ];
    }
}
