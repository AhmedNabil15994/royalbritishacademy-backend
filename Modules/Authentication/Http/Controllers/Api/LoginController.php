<?php

namespace Modules\Authentication\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Authentication\Repositories\Api\AuthenticationRepository;
use Modules\Apps\Http\Controllers\Api\ApiController;
use Modules\Authentication\Foundation\Authentication;
use Modules\Authentication\Http\Requests\Api\LoginRequest;

class LoginController extends ApiController
{
    use Authentication;

    private $auth;
    private $guard;

    public function __construct(AuthenticationRepository $auth)
    {
        $this->auth = $auth;
    }

    public function postLogin(LoginRequest $request)
    {
        $failedAuth =  $this->auth->login($request);

        if ($failedAuth['status'] == 0) {
            return $this->invalidData($failedAuth['data'], [], 422);
        }

        return $this->auth->tokenResponse($request, $failedAuth['data']);
    }

    public function logout(Request $request)
    {
        $fcmToken=$request->user()->fcmTokens()->where('firebase_token', $request->token)->first();

        if ($fcmToken) {
            $fcmToken->delete();
        }
        $request->user()->currentAccessToken()->delete();
        return $this->response([], __('authentication::api.logout.messages.success'));
    }
}
