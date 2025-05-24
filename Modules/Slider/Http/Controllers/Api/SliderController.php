<?php

namespace Modules\Slider\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Slider\Repositories\Api\SliderRepository as Slider;
use Modules\Apps\Http\Controllers\Api\ApiController;
use Modules\Slider\Transformers\Api\SliderResource;

class SliderController extends ApiController
{
    private $slider;

    function __construct(Slider $slider)
    {
        $this->slider = $slider;
    }

    public function sliders(Request $request)
    {
        return SliderResource::collection($this->slider->getAll($request));
    }
}
