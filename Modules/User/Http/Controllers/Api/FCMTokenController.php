<?php

namespace Modules\User\Http\Controllers\Api;

use IlluminateAgnostic\Arr\Support\Carbon;
use Modules\User\Entities\FirebaseToken;
use Modules\User\Http\Requests\Api\FCMTokenRequest;
use Modules\User\Transformers\Api\FCMTokenResource;
use Modules\Apps\Http\Controllers\Api\ApiController;
use Modules\Notification\Traits\SendNotificationTrait;

class FCMTokenController extends ApiController
{
    use SendNotificationTrait;
    public function store(FCMTokenRequest $request)
    {
        $data= $request->all();
        $data['device_type'] = FirebaseToken::DEVICE_TYPES[$request->device_type];
        $data['user_id'] = $request->user_id ?? null;
        $data['lang'] = locale();
        
        $firebaseToken = FirebaseToken::updateOrCreate(['firebase_token'=>$data['firebase_token']], $data);
        
        return $this->response(new FCMTokenResource($firebaseToken));
    }
    public function list()
    {
        return FirebaseToken::all();
    }
}
