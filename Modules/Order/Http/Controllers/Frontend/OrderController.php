<?php

namespace Modules\Order\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Cart\Traits\CartTrait;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Modules\Coupon\Http\Controllers\Frontend\CouponController;
use Modules\Order\Mail\BoughtCourse;
use Modules\Transaction\Services\TapPaymentService;
use Modules\Transaction\Traits\PaymentTrait;
use Modules\Transaction\Services\PaymentService;
use Modules\Authentication\Foundation\Authentication;
use Modules\Transaction\Services\MyFatoorahPaymentService;
use Modules\Order\Http\Requests\Frontend\CreateOrderRequest;
use Modules\Order\Repositories\Frontend\OrderRepository as Order;
use Modules\Course\Repositories\Frontend\CourseRepository as Course;
use Modules\Authentication\Repositories\Frontend\AuthenticationRepository;

class OrderController extends Controller
{
    use Authentication;
    use CartTrait;
    use PaymentTrait;


    public function __construct(public Order $order, public PaymentService $payment, public Course $course, public AuthenticationRepository $auth)
    {
    }

    public function index(Request $request)
    {

        $courses = $this->getCartContent();

        if (count($courses) > 0) {
            return view('order::frontend.checkout', compact('courses'));
        }

        return redirect()->route('frontend.cart.index');
    }

    public function createView()
    {

        $cart = $this->getCartContent();
        return view('order::frontend.show', compact('cart'));
    }

    public function create(Request $request)
    {
        $cart = $this->getCartContent();
        if (auth()->guest()) {
            return redirect()->route('frontend.auth.login', ['from' => 'checkout']);
        }
        /* if (!auth()->check()) {
            $this->auth->register($request->validated());
            $this->loginAfterRegister($request);
        } */
        if (count($cart) > 0) {
            return $this->addOrder($request);
        }

        return redirect()->route('frontend.cart.index');
    }

    public function event(CreateOrderRequest $request)
    {
        $event = $this->course->findEventBySlug($request['slug']);

        $order =  $this->order->createOrderEvent($event);

        if ($request['payment'] != 'cash') {
            $url = $this->payment->send($order, 'orders', $request['payment']);
            return redirect($url);
        }

        return view('order::frontend.show_event', compact('order'));
    }

    public function addOrder($data)
    {
        DB::beginTransaction();

        if (!auth()->check()) {
            return redirect()->route('frontend.register');
        } else {
            $user = auth()->user();
        }

        $data['user_id'] = $user->id;

        $order =  $this->order->create($data);
        $payment = $this->getPaymentGateway('upayment');
        DB::commit();

        $redirect = $payment->send($order, 'orders');

        if (isset($redirect['status'])) {

            if ($redirect['status'] == true) {
                return redirect()->away($redirect['url']);
            } else {
                return back()->withInput()->withErrors(['payment' => 'Online Payment not valid now']);
            }
        }

        return 'field';
    }

    public function success(Request $request)
    {
        $this->order->update($request['OrderID'], true);
        $this->clearCart();
        return redirect()->route('frontend.order.complated');
    }

    public function failed(Request $request)
    {
        return redirect()->route('frontend.cart.index')->with([
            'status'    => 'danger',
            'msg'      => __('Failed Payment , please try again'),
        ]);
    }

    public function successTap(Request $request)
    {
        $data = (new TapPaymentService())->getTransactionDetails($request);

        $request = PaymentTrait::buildTapRequestData($data, $request);
        if ($request->Result == 'CAPTURED') {
            return $this->success($request);
        }
        return $this->failed($request);

    }

    public function successUpayment(Request $request)
    {   
        if ($request->Result == 'CAPTURED') {
            return $this->success($request);
        }
        return $this->failed($request);
    }

    public function myFatoorahCallBack(Request $request)
    {
        $data = (new MyFatoorahPaymentService())->GetPaymentStatus($request->paymentId , 'paymentId');

        $request = PaymentTrait::buildMyFatoorahRequestData($data, $request);

        if ($request->Result == 'CAPTURED') {
            return $this->success($request);
        }
        return $this->failed($request);

    }

    public function orderComplated(Request $request)
    {
        return view('order::frontend.success-order-payment');
    }
}
