<?php

namespace Modules\Course\Http\Controllers\Frontend;

use Illuminate\Routing\Controller;
use Modules\Course\Http\Requests\Frontend\UserVideoRequest;
use Modules\Course\Repositories\Frontend\UserVideoRepository;

class UserVideoController extends Controller
{
    public $userVideoRepository;
    public function __construct(UserVideoRepository $userVideoRepository)
    {
        $this->userVideoRepository = $userVideoRepository;
    }


    /**
      * Provision a new web server.
      *
      * @return \Illuminate\Http\Response
      */
    public function __invoke(UserVideoRequest $request)
    {
        $userVideo=$this->userVideoRepository->create($request);
        return response()->json($userVideo);
    }
}
