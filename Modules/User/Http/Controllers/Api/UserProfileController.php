<?php

namespace Modules\User\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Course\Transformers\Api\{CourseCardResource,MyNoteCardResource};
use Modules\Apps\Http\Controllers\Api\ApiController;
use Modules\Course\Transformers\Api\CourseResource;
use Modules\Package\Transformers\Api\PackageCardResource;

class UserProfileController extends ApiController
{

    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function myCourses(Request $request)
    {
        $coursesIds = $request->user()->my_courses->latest()->get();
        $coursesIds = count($coursesIds) ? $coursesIds->when(
                request('status'),
                fn($collection, $val) => $collection->filter(function ($course) {

                    switch(request()->status){
                        case 'current':
                            return $course->User_complete_percentage < 100;
                        case 'complated':
                            return $course->User_complete_percentage == 100;
                    }

                    return true;
                })->flatten()
            )->pluck('id')->toArray() : [];

        return CourseResource::collection($request->user()->my_courses->whereIn('courses.id',$coursesIds)->latest()->paginate(10));
    }

    public function myNotes(Request $request)
    {
        return MyNoteCardResource::collection($request->user()->my_notes->latest()->paginate(10));
    }

    public function myPackages(Request $request)
    {
        return PackageCardResource::collection($request->user()->my_packages->latest()->paginate(10));
    }
}
