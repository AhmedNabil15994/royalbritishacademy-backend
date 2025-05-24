<?php

namespace Modules\Apps\Http\Controllers\Api;

class MobileVersionController extends ApiController
{

   public function responseJson($data = null)
   {
       return $data ? $this->response($data) : $this->response([]);
   }


    public function lastVersion()
    {
        $system = request('system') ?? 'ios';

        return $this->responseJson([
            'version' => setting("mobile_apps_updates","$system.version"),
            'production_status' => setting("mobile_apps_updates","$system.production_status") && in_array(setting("mobile_apps_updates","$system.production_status"),[1,'on'])  ? true : false,
            'force_update' => setting("mobile_apps_updates","$system.force_update") && setting("mobile_apps_updates","$system.force_update") == "on" ? true : false,
        ]);
    }
}
