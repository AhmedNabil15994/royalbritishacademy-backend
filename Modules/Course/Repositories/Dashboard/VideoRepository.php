<?php

namespace Modules\Course\Repositories\Dashboard;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Modules\Course\Entities\Video;
use Modules\Core\Repositories\Dashboard\CrudRepository;

class VideoRepository extends CrudRepository
{
    private $video_api;

    public function __construct()
    {
        parent::__construct(Video::class);
        $this->video_api = new CourseVideoApiRepository();
        $this->fileAttribute = ['thumb' => 'thumb'];
    }


    /**
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function uploadVideo($model, Request $request, $fileName)
    {
        $file = $request->file($fileName);

        $credential = $this->video_api->createObtainCredentials();
        $response = $this->video_api->uploadVideo($credential, $file);
        if (isset($response['status']) && $response['status'] == 1) {
            $credential->update(['status' => 'pending']);
        }
        $data['video_link'] = $credential->api_video_id;
        $model->video()->create($data);
    }

    /**
     * @param Request $request
     * @param $course
     * @return mixed
     * @throws \Exception
     */
    public function updateVideo($model, Request $request, $fileName)
    {

        $file = $request->file($fileName);

        $previousVideo = $model->video;

        $credential = $this->video_api->createObtainCredentials();
        
        $response = $this->video_api->uploadVideo($credential, $file);

        if (isset($response['status']) && $response['status'] == 1) {
            $credential->update(['status' => 'pending']);
        }
        $data['video_link'] = $credential->api_video_id;

        $model->video()->create($data);

        if ($previousVideo) {
            $this->deletePreviousVideo($previousVideo);
        }
    }

    public function deletePreviousVideo($video)
    {
        $this->video_api->deleteVideo($video->video_link);
        $video->credential()->delete();
        $video->delete();
    }
}
