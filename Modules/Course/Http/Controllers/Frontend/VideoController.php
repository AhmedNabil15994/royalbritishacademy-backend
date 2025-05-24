<?php

namespace Modules\Course\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Course\Entities\Video;
use Modules\Course\Repositories\Dashboard\CourseVideoApiRepository;

class VideoController extends Controller
{
    private $videoIntegration;

    public function __construct(CourseVideoApiRepository $videoIntegration)
    {
        $this->videoIntegration = $videoIntegration;
    }

    public function videoResponse(Request $request)
    {
      
        $lessonContentId = $request->lesson_content_id;

        $video = $this->videoIntegration->getOtp($request['video_id'])->getData()->data;
        if ($video) {
            return view('course::frontend.courses.videos.embed', compact('video', 'lessonContentId'))->render();
        } else {
            return response()->json('not found', 404);
        }
    }
}
