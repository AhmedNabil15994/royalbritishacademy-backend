<?php

namespace Modules\Cart\Traits;

use Cart;
use Illuminate\Support\Str;
use Modules\Cart\Entities\DatabaseStorageModel;
use Darryldecode\Cart\CartCondition;
use Modules\Coupon\Entities\Coupon;

trait CartTrait
{
    public $authUserGuard;
    protected $DiscountCoupon = 'coupon_discount';

    public function getCart()
    {
        return Cart::session($this->userToken());
    }

    public function getCartContent()
    {
        return Cart::session($this->userToken())->getContent();
    }

    public function userToken()
    {
        if (request()->user_token){

            $cartKey = request()->user_token;

        }elseif (request()->user()){

            $cartKey = request()->user()->id;

        }
        else {
            if (is_null(get_cookie_value(config('core.config.constants.CART_KEY')))) {
                $cartKey = Str::random(30);
                set_cookie_value(config('core.config.constants.CART_KEY',''), $cartKey);
            } else {
                $cartKey = get_cookie_value(config('core.config.constants.CART_KEY'));
            }
        }

        return $cartKey;
    }

    public function addToCart($item, $type, $quantity = 1)
    {
        $inCart = $this->findItemById($item, $type);

        if (!is_null($inCart)) {
            $this->updateItemInCart($item, $type);
        }

        $this->addItemToCart($item, $type, $quantity);

        return true;
    }

    public function findItemById($item, $type)
    {
        return $this->getCartContent()->get($item['id'] . '-' . $type);
    }

    public function addItemToCart($item, $type, $quantity = 1)
    {
        $cart = $this->getCart();
        if ($item['offer']) {
            $item['offer'] = ($item['offer'])->jsonSerialize();
            $price = $item['offer']['offer_price'];
        } else {
            $price = (floatval($item['price']));
        }

        $checkCoupon = $this->getConditionByName('coupon_discount');
        $discount_value = 0;
        $coupon = null;
        if($checkCoupon){
            $this->removeCouponConditionByName();
        }

        $cart->add([
            'id' => $item['id'] . '-' . $type,
            'name' => $item['title'],
            'price' => $price,
            'quantity' => $quantity ?? 1,
            'attributes' => [
                'item_id' => $item['id'],
                'type' => $type,
                'image' => asset($item['image']),
                'product' => $item,
            ]
        ]);

        if($checkCoupon){
            $attrs = $checkCoupon->getAttributes();
            $couponId = $attrs['coupon']['id'] ?? 0;
            $coupon = Coupon::find($couponId);
            if ($coupon->discount_type == "value"){
                $discount_value = $coupon->discount_value;
            }elseif ($coupon->discount_type == "percentage"){
                $discount_value = ($this->getCart()->getSubTotal() * $coupon->discount_percentage) / 100;
            }
            $this->discountCouponCondition($coupon,$discount_value);
        }

        return true;
    }

    public function updateItemInCart($item, $type)
    {
        $cart = $this->getCart();
        $cart->update($item['id'] . '-' . $type, [
            'quantity' => [
                'relative' => false,
                'value' => 0,
            ]
        ]);
        return true;
    }

    public function discountCouponCondition($coupon, $discount_value)
    {
        $this->removeCouponConditionByName();
        $cart = $this->getCart();

        $coupon_discount = new CartCondition([
            'name' => $this->DiscountCoupon,
            'type' => $this->DiscountCoupon,
            'target' => 'subtotal',
            'value' => number_format($discount_value * -1, 3),
            'attributes' => [
                'coupon' => [
                    'id' => $coupon->id,
                    'code' => $coupon->code,
                    'title' => $coupon->title,
                    'discount_type' => $coupon->discount_type,
                    'discount_percentage' => $coupon->discount_percentage,
                    'discount_value' => $coupon->discount_value,
                ]
            ]
        ]);

        $cart->condition([$coupon_discount]);
        return true;
    }

    public function removeCouponConditionByName()
    {
        $cart = $this->getCart();
        $cart->removeCartCondition($this->DiscountCoupon);
        return true;
    }

    public function getConditionByName($name)
    {
        $cart = $this->getCart();

        return $cart->getCondition($name) ?? null;
    }

    public function getCartConditions()
    {
        $cart = $this->getCart();
        $res = [];
        if (count($cart->getConditions()->toArray()) > 0) {
            $i = 0;
            foreach ($cart->getConditions() as $k => $condition) {
                $res[$i]['target'] = $condition->getTarget(); // the target of which the condition was applied
                $res[$i]['name'] = $condition->getName(); // the name of the condition
                $res[$i]['type'] = $condition->getType(); // the type
                $res[$i]['value'] = $condition->getValue(); // the value of the condition
                $res[$i]['order'] = $condition->getOrder(); // the order of the condition
                $res[$i]['attributes'] = $condition->getAttributes(); // the attributes of the condition, returns an empty [] if no attributes added

                $i++;
            }
        }
        return $res;
    }

    public function removeItem($id, $type)
    {
        $cart = $this->getCart();
        $checkCoupon = $this->getConditionByName('coupon_discount');
        $discount_value = 0;
        $coupon = null;
        if($checkCoupon){
            $this->removeCouponConditionByName();
        }
        $remove = $cart->remove($id . '-' . $type);

        if($checkCoupon){
            $attrs = $checkCoupon->getAttributes();
            $couponId = $attrs['coupon']['id'] ?? 0;
            $coupon = Coupon::find($couponId);
            if ($coupon->discount_type == "value"){
                $discount_value = $coupon->discount_value;
            }elseif ($coupon->discount_type == "percentage"){
                $discount_value = ($this->getCart()->getSubTotal() * $coupon->discount_percentage) / 100;
            }
            $this->discountCouponCondition($coupon,$discount_value);
        }
        if((int)$this->cartSubTotal() == 0){
            $cart->clear();
            $cart->clearCartConditions();
        }
        return  $remove;
    }

    public function clearCart()
    {
        $cart = $this->getCart();
        $cart->clear();
        $cart->clearCartConditions();
        return true;
    }

    public function cartSubTotal()
    {
        $cart = $this->getCart();
        return number_format($cart->getTotal(),3);

    }

    public function cartTotal()
    {
        $cart = $this->getCart();
        $couponDiscount = $this->getConditionByName('coupon_discount');
        if($couponDiscount)
            $couponDiscount = - $couponDiscount->getValue();
        else
            $couponDiscount = 0;

        return number_format($cart->getTotal() + $couponDiscount,3);
    }

    public function cartCount()
    {
        $cart = $this->getCartContent();
        return $cart->count();
    }

    public function updateCartKey($userToken, $newUserId)
    {
        DatabaseStorageModel::where('id', $userToken . '_cart_conditions')->update(['id' => $newUserId . '_cart_conditions']);
        DatabaseStorageModel::where('id', $userToken . '_cart_items')->update(['id' => $newUserId . '_cart_items']);
        return true;
    }
}
