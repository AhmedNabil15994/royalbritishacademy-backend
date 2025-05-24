<?php

namespace Modules\Authentication\Http\Controllers\Api;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Modules\User\Transformers\Api\UserResource;
use Modules\Apps\Http\Controllers\Api\ApiController;
use Modules\Authentication\Foundation\Authentication;
use Modules\Authentication\Http\Requests\Api\RegisterRequest;
use Modules\Authentication\Notifications\Api\WelcomeNotification;
use Modules\Authentication\Http\Requests\Api\CompleteRegisterRequest;
use Modules\Authentication\Notifications\Api\ResetPasswordNotification;
use Modules\Authentication\Repositories\Api\AuthenticationRepository as AuthenticationRepo;

class RegisterController extends ApiController
{
    use Authentication;

    private $repository;
    public function __construct(AuthenticationRepo $repository)
    {
        $this->repository = $repository;
    }

    public function register(RegisterRequest $request)
    {
        $registered = $this->repository->register($request);
        if ($registered) {
            return $this->repository->tokenResponse($request, $registered);
        }
        return $this->error(__('authentication::api.register.messages.failed'), [], 401);
    }


    public function completeRegister(CompleteRegisterRequest $request)
    {
        $model = $this->repository->completeRegister(auth()->user(), $request);

        if ($model) {
            return Response()->json(['msg' => __('apps::api.messages.success')]);
        }

        return $this->error(__('apps::api.messages.failed'));
    }
}
