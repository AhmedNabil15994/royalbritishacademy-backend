<?php

namespace Modules\Order\Repositories\Api;

use Modules\Order\Traits\OrderCalculationTrait;
use Modules\Order\Entities\OrderStatus;
use Modules\Order\Entities\Order;
use Modules\User\Entities\User;
use Carbon\Carbon;
use Auth;
use DB;

class OrderRepository
{
    use OrderCalculationTrait;

    public function __construct(Order $order, OrderStatus $status, User $user)
    {
        $this->user      = $user;
        $this->order     = $order;
        $this->status    = $status;
    }

    public function getAllByUser()
    {
        return $this->order->where('user_id', auth()->id())->get();
    }

    public function findById($id)
    {
        return $this->order->where('id', $id)->first();
    }

    public function rateOrder($request)
    {
        $order = $this->findById($request['order_id']);

        $order->rate()->updateOrCreate(
            [
            'order_id'  => $request['order_id']
        ],
            [
            'order_rate'     => $request['order_rate'],
            'service_rate'   => $request['service_rate'],
            'vendor_rate'    => $request['vendor_rate'],
            'delivery_rate'  => $request['delivery_rate'],
        ]
        );

        return true;
    }

    public function create($request, $status = true)
    {
        DB::beginTransaction();

        try {
            $data = $this->calculateTheOrder($request);

            $status = $this->statusOfOrder(true);

            $user =  $this->user->find($request['user_token']);

            $order = $this->order->create([
                'is_holding'        => false,
                'subtotal'          => $data['subtotal'],
                'discount'          => 0.000,
                'total'             => $data['total'],
                'vendor_id'         => $data['vendor_id'],
                'user_id'           => $user ? $user['id'] : 1,
                'order_status_id'   => $status->id,
            ]);

            $this->orderProducts($order, $data);
            $this->orderAddress($order, $data);

            DB::commit();
            return $order;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function orderProducts($order, $data)
    {
        foreach ($data['order_products'] as $key => $product) {
            $orderProduct = $order->orderProducts()->create([
                'product_id'    => $product['product']['id'],
                'price'         => $product['price'],
                'qty'           => $product['qty'],
                'total'         => $product['total'],
            ]);

            if (!is_null($product['options'])) {
                foreach ($product['options'] as $key => $option) {
                    $orderOption = $orderProduct->orderProductOptions()->create([
                        'option_id' => $option['id']
                    ]);

                    foreach ($option['values'] as $optionValue) {
                        $orderOption->orderProductOptionValues()->create([
                            'option_value_id' => $optionValue['id']
                        ]);
                    }
                }
            }

            if (!is_null($product['attributes'])) {
                foreach ($product['attributes'] as $key => $attributes) {
                    $orderAttribute = $orderProduct->orderProductAttributes()->create([
                        'attribute_id' => $attributes['id']
                    ]);

                    foreach ($attributes['values'] as $attribute) {
                        $orderAttribute->orderProductAttributeValues()->create([
                            'attribute_value_id' => $attribute['id'],
                            'price'              => $attribute['price'],
                            'qty'                => 1,
                            'total'              => $attribute['price']
                        ]);
                    }
                }
            }
        }
    }

    public function orderAddress($order, $data)
    {
        $order->address()->create([
            'floor'         => $data['address']['floor'],
            'building'      => $data['address']['building'],
            'door'          => $data['address']['door'],
            'street'        => $data['address']['street'],
            'address'       => $data['address']['address'],
            'area_id'       => $data['address']['area_id'],
            'username'      => $data['address']['username'],
            'mobile'        => $data['address']['mobile'],
            'email'         => $data['address']['email'],
        ]);
    }

    public function updateOrder($request)
    {
        $order = $this->findById($request['OrderID']);

        $status = ($request['Result'] == 'CAPTURED') ? $this->statusOfOrder(true) : $this->statusOfOrder(false);

        $order->update([
          'order_status_id' => $status['id'],
          'is_holding'      => false
        ]);

        $order->transactions()->updateOrCreate(
            [
            'transaction_id'  => $request['OrderID']
          ],
            [
            'auth'          => $request['Auth'],
            'tran_id'       => $request['TranID'],
            'result'        => $request['Result'],
            'post_date'     => $request['PostDate'],
            'ref'           => $request['Ref'],
            'track_id'      => $request['TrackID'],
            'payment_id'    => $request['PaymentID'],
        ]
        );

        return ($request['Result'] == 'CAPTURED') ? true : false;
    }

    public function statusOfOrder($type)
    {
        if ($type) {
            $status = $this->status->successPayment()->first();
        }

        if (!$type) {
            $status = $this->status->failedPayment()->first();
        }

        return $status;
    }
}
