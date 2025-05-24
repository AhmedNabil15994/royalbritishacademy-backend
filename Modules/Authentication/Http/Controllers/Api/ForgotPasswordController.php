<?php

namespace Modules\Authentication\Http\Controllers\Api;

use Modules\Apps\Http\Controllers\Api\ApiController;
use Modules\Authentication\Http\Requests\Api\ForgetPasswordRequest;
use Modules\Authentication\Notifications\Api\ResetPasswordNotification;
use Modules\Authentication\Repositories\Api\AuthenticationRepository as Authentication;

class ForgotPasswordController extends ApiController
{
    private $auth;

    public function __construct(Authentication $auth)
    {
        $this->auth = $auth;
    }

    public function forgetPassword(ForgetPasswordRequest $request)
    {
        $token = $this->auth->createToken($request);
        
        if ($token) {
            $token['user']->notify((new ResetPasswordNotification($token))->locale(locale()));

            return $this->response([], __('authentication::api.forget_password.messages.success'));
        }

        return $this->error(__('authentication::api.forget_password.messages.failed'));
    }
}
