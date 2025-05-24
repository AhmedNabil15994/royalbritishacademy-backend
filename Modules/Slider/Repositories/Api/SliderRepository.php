<?php

namespace Modules\Slider\Repositories\Api;

use Modules\Slider\Entities\Slider;

class SliderRepository
{
    private $slider;
    public function __construct(Slider $slider)
    {
        $this->slider = $slider;
    }

    public function getAll($request,$order = 'id', $sort = 'desc')
    {
        return $this->slider->active()->Published()->orderBy($order, $sort)->get();
    }
}
