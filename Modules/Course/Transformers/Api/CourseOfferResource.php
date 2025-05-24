<?php

namespace Modules\Course\Transformers\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class CourseOfferResource extends JsonResource
{
    public function toArray($request)
    {
        if (!is_null($this->offer_price)) {
            $result['type'] = 'amount';
            $result['offer_price'] = $this->offer_price;
            $result['percentage'] = number_format((floatval($this->offer_price) / floatval($this->course->price)) * 100, 3);
        } else {
            $result['type'] = 'percentage';
            $result['offer_price'] = number_format(calculateOfferAmountByPercentage($this->course->price, $this->percentage), 3);
            $result['percentage'] = $this->percentage;
        }
        
        $result['offer_percentage_price'] = null;

        return $result;
    }
}
