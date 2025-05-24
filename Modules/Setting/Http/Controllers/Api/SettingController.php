<?php

namespace Modules\Setting\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Apps\Http\Controllers\Api\ApiController;

class SettingController extends ApiController
{
    public function settings()
    {
        $settings =  config('api_setting');

        return $this->response($settings);
    }

}
