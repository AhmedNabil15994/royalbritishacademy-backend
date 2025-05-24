<?php

namespace Modules\User\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\User\Http\Requests\Frontend\UpdateProfileRequest;
use Modules\User\Repositories\Frontend\UserRepository;

class ProfileController extends Controller
{
    private $user;

    function __construct(UserRepository $userRepository)
    {
        $this->user = $userRepository;
    }

    
    public function index()
    {
        return view('user::frontend.profile.index');
    }

    public function edit()
    {
        return view('user::frontend.profile.edit');
    }

    public function myCourses(Request $request)
    {

        $courses = auth()->user()->my_courses->get();
        return view('user::frontend.profile.my-courses', compact('courses'));
    }

    public function update(UpdateProfileRequest $request)
    {
        $this->user->update($request);

        return redirect()->route('frontend.profile.index');
    }
}
