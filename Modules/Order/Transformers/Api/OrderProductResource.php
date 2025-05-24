<?php

namespace Modules\Order\Transformers\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderProductResource extends JsonResource
{
    public function toArray($request)
    {
        return [
           'id'                 => $this->id,
           'price'              => $this->price,
           'qty'                => $this->qty,
           'total'              => $this->total,
           'title'              => $this->product->translate(locale())->title,
           'options'            => OrderProductOptionResource::collection($this->orderProductOptions),
           'attributes'         => OrderProductAttributeResource::collection($this->orderProductAttributes)
       ];
    }
}
