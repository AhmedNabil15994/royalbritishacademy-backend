<?php
namespace Modules\Course\Repositories\Dashboard;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Modules\Course\Entities\LessonContent;
use Modules\Core\Repositories\Dashboard\CrudRepository;
use Modules\Course\Entities\Video;
class LessonContentRepository extends CrudRepository
{
    public $videoRepo;
    public function __construct()
    {
        parent::__construct(LessonContent::class);
        $this->fileAttribute = ['resources' => 'resources'];
        $this->videoRepo = new VideoRepository();
    }
    public function prepareData(array $data, Request $request, $is_create = true): array
    {
        if ($request->type !== 'exam') {
            Arr::pull($data, 'exam_id', null);
        }
        return $data;
    }
    public function modelUpdated($model, $request): void
    {
        if ($request['type'] == 'resource') {
            $this->restExam($model);
        }
        if ($request['type'] == 'exam') {
            $this->restResource($model);
        }

        if($request->hasFile('video')){
            $this->videoRepo->updateVideo($model,$request,'video');
        }
    }

    public function modelCreated($model, $request, $is_created = true): void
    {
        if($request->hasFile('video')){
            $this->videoRepo->uploadVideo($model,$request,'video');
        }
    }

    /**
     * Model update call back function
     *
     * @param mixed $model
     * @return void
     */
    public function modelForceDeleting($model): void
    {
        if($model->video)
            $this->videoRepo->deletePreviousVideo($model->video);
    }

    public function restVideo($model)
    {
        //todoList implement  function to delete video from database and video service
    }
    public function restExam($model)
    {
        $model->update(['exam_id' => null]);
    }
    public function restResource($model)
    {
        $model->clearMediaCollection('resources');
    }

    /*
        * Generate Datatable
        */
    public function QueryTable($request)
    {
        $query = $this->model->DashboardTrainer()->when(
            request('req.course_id'),
            fn ($q) =>  $q->where('course_id', request('req.course_id'))
        )->where(function ($query) use ($request) {
            $query->where('lesson_contents.id', 'like', '%' . $request->input('search.value') . '%');
            foreach ($this->getModelTranslatable() as $key) {
                $query->orWhere('' . $key . '->' . locale(), 'like', '%' . $request->input('search.value') . '%');
            }
            $query->orWhere(function ($q){
                $q->whereHas('course', function($query)  {
                    $query->where("courses.title->" . locale(), 'like', '%' . \request('search.value') . '%')
                        ->orWhere("courses.slug->" . locale(), 'like', '%' . \request('search.value') . '%');
                });
            });
        });

        $query = $this->filterDataTable($query, $request);
        return $query;
    }

    /**
     * when to delete video
     * case 1 we have another one
     * case 2 we have another type
     */
    /**
     * when to reset exam_id
     * case 1 we have another type
     */
    /**
     * when to reset resource
     * case 1 we have another type
     */
}
