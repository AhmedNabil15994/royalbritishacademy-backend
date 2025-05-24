<?php

namespace Modules\Course\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Apps\Http\Controllers\Api\ApiController;
use Modules\Course\Entities\Course;
use Modules\Course\Entities\LessonContent;
use Modules\Course\Entities\Video;
use Modules\Course\Http\Requests\Client\GetOtpRequest;
use Modules\Course\Repositories\Dashboard\CourseVideoApiRepository;

class VideoController extends ApiController
{
    private $videoIntegration;

    public function __construct(CourseVideoApiRepository $videoIntegration)
    {
        $this->videoIntegration = $videoIntegration;

        if(in_array(request()->route()->getName(),['api.video.otp']) && request()->type == 'lesson_video'){

            $this->middleware('auth:sanctum');
        }
    }

    public function getOtp(GetOtpRequest $request)
    {
        switch($request->type){
            case 'course_intro':
                $video = Course::active()->find($request->model_id)?->video;
                break;
            case 'lesson_video':

                $video = LessonContent::whereIn('course_id', optional($request->user()->my_courses->pluck('id'))->toArray())->find($request->model_id)?->video;
                break;
            default:
                $video = false;
                break;
        }

        if ($video) {
            $video = $this->videoIntegration->getOtp($video->video_link)->getData()->data;

            if($video)
                return $this->response([
                    'otp' => $video->otp,
                    'playbackInfo' => $video->playbackInfo,
                ]);
        }

        return $this->error('not found',[],404);
    }

    public function webHook(Request $request)
    {
        $videoId = isset($request['payload']['id']) ? $request['payload']['id'] : false;

        $video = Video::where('video_link',$videoId)->first();

        if($video){

            $video_status = CourseVideoApiRepository::checkVideoStatus($videoId);
            $response = (new CourseVideoApiRepository())->getVideos($videoId);
            $duration = data_get($response->getOriginalContent(), 'data.0.length');
            $thumb = data_get($response->getOriginalContent(), 'data.0.posters.0.posterUrl');

            if($video_status){

                if ($video_status == 'ready') {

                    $video->credential()->update(['status' => 'loaded']);
                    $video->update(['video_length' => $duration, 'thumb' => $thumb,'loading_status' => 'loaded','status' => true]);

                }
            }
        }

        return response()->json(['message' => 'success']);
    }
}
