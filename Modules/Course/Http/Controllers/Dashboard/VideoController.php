<?php

namespace Modules\Course\Http\Controllers\Dashboard;

use Illuminate\Routing\Controller;
use Modules\Course\Entities\Video;
use Modules\Course\Entities\Course;
use Modules\Core\Traits\Dashboard\CrudDashboardController;
use Modules\Course\Repositories\Dashboard\CourseVideoApiRepository;

class VideoController extends Controller
{
    use CrudDashboardController  {
        CrudDashboardController::__construct as private __tConstruct;
    }
    private $video_api;

    public function __construct(Video $video, CourseVideoApiRepository $videoApi)
    {
        $this->__tConstruct();
        $this->model = $video;
        $this->video_api = $videoApi;
    }


    public function extraData($model)
    {
        $courses=Course::with('lessons')->get()->transform(function ($course) {
            return [$course->title =>$course->lessons->pluck('title', 'id')];
        });

        return [ 'video_view' => $this->video_api->buildVideo(optional($model)->video_link),'courses'=>$courses];
    }
}
