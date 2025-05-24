<?php

namespace Modules\Authentication\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Authentication\Http\Requests\Api\UpdateProfileRequest;
use Modules\Apps\Http\Controllers\Api\ApiController;
use Modules\Authentication\Repositories\Api\AuthenticationRepository as Authentication;
use Modules\User\Http\Requests\Api\ChangePasswordRequest;
use Modules\User\Repositories\Api\UserRepository as User;
use Modules\User\Transformers\Api\UserResource;

class ProfileController extends ApiController
{
    private $auth;
    private $user;

    public function __construct(Authentication $auth,User $user)
    {
        $this->auth = $auth;
        $this->user = $user;
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        $user = $this->auth->updateProfile($request);

        if ($user) {
            return $this->response($this->auth->profileInfo($request));
        }
        return $this->error('', [], 400);
    }

    public function updateAddress(Request $request)
    {
        $user = $this->auth->updateAddress($request);

        if ($user) {
            return $this->response($this->auth->profileInfo($request));
        }
        return $this->error('', [], 400);
    }
    public function Profile(Request $request)
    {
        return $this->response($this->auth->profileInfo($request));
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $this->user->changePassword($request);

        $user =  $this->user->findById(auth()->id());

        return $this->response(new UserResource($user));
    }

    public function deleteAccount(Request $request)
    {
        $fcmToken = $request->user()->fcmTokens()->where('firebase_token', $request->token)->first();

        if ($fcmToken) {
            $fcmToken->delete();
        }
        $request->user()->currentAccessToken()->delete();
        $this->user->deleteAccount();

        return $this->response([]);
    }
}
