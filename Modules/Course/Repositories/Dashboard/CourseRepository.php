<?php

namespace Modules\Course\Repositories\Dashboard;

use Illuminate\Http\Request;
use IlluminateAgnostic\Collection\Support\Carbon;
use Modules\Course\Entities\Course;
use Modules\Course\Service\CourseTargetService;
use Modules\Core\Repositories\Dashboard\CrudRepository;

class CourseRepository extends CrudRepository
{
    public CourseTargetService $courseTargetService;
    public $videoRepo;

    public function __construct()
    {
        parent::__construct(Course::class);
        $this->statusAttribute     = ['is_certificated', 'is_live','status','is_latest'];
        $this->fileAttribute       = ['image' => 'image'];
        $this->courseTargetService = new CourseTargetService();
        $this->videoRepo = new VideoRepository();
    }

    public function prepareData(array $data, Request $request, $is_create = true): array
    {
        if ($request->is_live) {
            $data['extra_attributes']['days'] = implode(',', $request['days_status']);
        }
        return $data;
    }
    public function modelCreated($model, $request, $is_created = true): void
    {
        $model->categories()->sync($request->category_id);
        $model->materials()->sync($request->material_id);
        $this->courseTargetService->handelTargets($model, $request);

        if(auth()->user()->can('trainer_access') && !auth()->user()->can('dashboard_access')){

            $model->update([
                'trainer_id' => auth()->id()
            ]);
        }

        if($request->hasFile('introduction_video')){
            $this->videoRepo->uploadVideo($model,$request,'introduction_video');
        }

        $this->courseOffer($model,$request);
    }
    public function modelUpdated($model, $request): void
    {
        $model->categories()->sync($request->category_id);
        $model->materials()->sync($request->material_id);
        $this->courseTargetService->handelTargets($model, $request);

        if(auth()->user()->can('trainer_access') && !auth()->user()->can('dashboard_access')){

            $model->update([
                'trainer_id' => auth()->id()
            ]);
        }

        if($request->hasFile('introduction_video')){
            $this->videoRepo->updateVideo($model,$request,'introduction_video');
        }

        $this->courseOffer($model,$request);
    }


    public function courseOffer($model, $request)
    {
        if (isset($request->offer_status) && $request->offer_status == 'on') {
            $data = [
                'status' => ($request['offer_status'] == 'on') ? true : false,
                // 'offer_price' => $request['offer_price'] ? $request['offer_price'] : $model->offer->offer_price,
                'start_at' => isset($request['start_at']) && $request['start_at'] ? Carbon::parse($request['start_at'])->toDateString() : $model->offer->start_at,
                'end_at' => isset($request['end_at']) && $request['end_at'] ? Carbon::parse($request['end_at'])->toDateString() : $model->offer->end_at,
            ];

            if ($request['offer_type'] == 'amount' && !is_null($request['offer_price'])) {
                $data['offer_price'] = $request['offer_price'];
                $data['percentage'] = null;
            } elseif ($request['offer_type'] == 'percentage' && !is_null($request['offer_percentage'])) {
                $data['offer_price'] = null;
                $data['percentage'] = $request['offer_percentage'];
            } else {
                $data['offer_price'] = null;
                $data['percentage'] = null;
            }

            $model->offer()->updateOrCreate(['course_id' => $model->id], $data);
        } else {
            if ($model->offer) {
                $model->offer()->delete();
            }
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

    public function filterDataTable($query, $request)
    {
        $query = parent::filterDataTable($query, $request);
        $query->DashboardTrainer()
            ->when(data_get($request, 'req.categories'), fn ($q, $v) => $q->categories((array)$v))
            ->when(data_get($request, 'req.material'), fn ($q, $v) =>
                $q->whereHas('materials', function($query) use($v) {
                    $query->where('material_id', $v);
                })
            )
            ->when(data_get($request, 'req.trainer'), fn ($q, $v) => $q->trainer($v));


        return $query;
    }
}
