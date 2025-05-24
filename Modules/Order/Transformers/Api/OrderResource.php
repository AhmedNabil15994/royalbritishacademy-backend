<?php

namespace Modules\Order\Transformers\Api;

use Modules\Vendor\Transformers\Api\VendorResource;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray($request)
    {
        return [
           'id'                 => $this->id,
           'subtotal'           => $this->subtotal,
           'discount'           => $this->discount,
           'total'              => $this->total,
           'products'           => OrderProductResource::collection($this->orderProducts),
           'order_status'       => $this->orderStatus->translate(locale())->title,
           'vendor'             => new VendorResource($this->vendor),
           'address'            => new OrderAddressResource($this->address),
           'rate'               => new OrderRateResource($this->rate),
           'created_at'         => $this->created_at,
       ];
    }
}
