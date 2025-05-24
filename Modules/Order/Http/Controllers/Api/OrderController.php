<?php

namespace Modules\Order\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Apps\Http\Controllers\Api\ApiController;
use Modules\Cart\Traits\CartTrait;
use Modules\Transaction\Services\MyFatoorahPaymentService;
use Modules\Transaction\Traits\PaymentTrait;
use Modules\Transaction\Services\PaymentService;
use Modules\Authentication\Foundation\Authentication;
use Modules\Order\Repositories\Frontend\OrderRepository as Order;
use Modules\Course\Repositories\Frontend\CourseRepository as Course;
use Modules\Authentication\Repositories\Frontend\AuthenticationRepository;

class OrderController extends ApiController
{
    use Authentication;
    use CartTrait;
    use PaymentTrait;


    public function __construct(public Order $order, public PaymentService $payment, public Course $course, public AuthenticationRepository $auth)
    {
    }

    public function create(Request $request)
    {
        $cart = $this->getCartContent();
        if (count($cart) > 0) {
            return $this->addOrder($request);
        }

        return $this->error(__('Your cart is impty'));
    }

    public function addOrder($data)
    {
        DB::beginTransaction();


        $user = $data->user();

        $data['user_id'] = $user->id;

        $order =  $this->order->create($data);
        $is_free = $order ? ($order->subtotal == 0) : false;
        if ($is_free) {
            DB::commit();
            $this->order->update((int)$order->id, true);
            $this->clearCart();
            return redirect()->route('api.orders.success.free');
        }
        $payment = $this->getPaymentGateway('upayment');
        DB::commit();

        $redirect = $payment->send($order, 'orders',$data->user_token,'api');

        if (isset($redirect['status'])) {

            if ($redirect['status'] == true) {
                $this->removeCouponConditionByName();
                return $this->response(['payment_ur' => $redirect['url']]);
            } else {
                return $this->error(__('Online Payment not valid now'));
            }
        }

        return $this->error('field');
    }

    public function success(Request $request)
    {
        $request->merge(['user_token' => $request['cust_ref']]);
        $this->order->update($request['OrderID'], true);
        $this->clearCart();
        return $this->response([], __('Payment completed successfully'));
    }

    public function successFree()
    {
        return $this->response([], __('Payment completed successfully'));
    }

    public function failed(Request $request)
    {
        return $this->error(__('Failed Payment , please try again'));
    }
    public function successUpayment(Request $request)
    {
        if ($request->Result == 'CAPTURED') {
            return $this->success($request);
        }
        return $this->failed($request);
    }

    public function successMyfatoorah(Request $request)
    {
        $data = (new MyFatoorahPaymentService())->GetPaymentStatus($request->paymentId , 'paymentId');

        $request = PaymentTrait::buildMyFatoorahRequestData($data, $request);

        if ($request->Result == 'CAPTURED') {
            return $this->success($request);
        }
        return $this->failed($request);

    }
}
