<?php

namespace Modules\Authentication\Http\Controllers\Api;

use Modules\Authentication\Http\Requests\Api\UpdatePassword;
use Modules\Authentication\Repositories\Api\AuthenticationRepository;
use Modules\Apps\Http\Controllers\Api\ApiController;

class UpdatePasswordController extends ApiController
{
    private $auth;

    public function __construct(AuthenticationRepository $auth)
    {
        $this->auth = $auth;
    }

    public function UpdatePassword(UpdatePassword $request)
    {
        $reset = $this->auth->UpdatePassword($request);

        if ($reset) {
            return $this->response('');
        } else {
            return $this->error(__('authentication::api.reset.validation.old_password.wrong'));
        }
    }
}
