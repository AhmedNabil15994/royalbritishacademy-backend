<?php

namespace Modules\Cart\Transformers\Api;

use Illuminate\Http\Resources\Json\JsonResource;
use IlluminateAgnostic\Collection\Support\Carbon;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
         return [
            'id' => $this['attributes']['item_id'],
            'name' => $this['name'],
            'price_before_offer' => number_format(floatval($this['attributes']['product']['price']),3),
            'price' => number_format($this['price'],3),
            'image' => $this['attributes']['image'],
            'sub_title' => $this['attributes']['product']['sub_title'],
            'category' => $this['attributes']['product']['category'],
            'offer' => isset($this['attributes']['product']['offer']) ? $this['attributes']['product']['offer'] : null,
        ];
    }
}
