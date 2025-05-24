<?php

namespace Modules\Order\Repositories\Dashboard;

use Modules\Core\Repositories\Dashboard\CrudRepository;
use Modules\Order\Entities\OrderCourse;

class OrderReportRepository extends CrudRepository
{


    public function __construct($model = null)
    {
        $this->model = OrderCourse::with(['course','order','user']);
    }

    public function QueryTable($request)
    {
        $query = $this->model->whereHas('order',function($q){
                    $q->where('order_status_id',1);
            })->whereHas('user',function ($query) use ($request){

            $query->where('name', 'like', '%' . $request->input('search.value') . '%');
            $query->orWhere('email', 'like', '%' . $request->input('search.value') . '%');
            $query->orWhere('mobile', 'like', '%' . $request->input('search.value') . '%');
        });

        $query = $this->filterDataTable($query, $request);

        return $query;
    }

    public function filterDataTable($query, $request)
    {

        // Search Categories by Created Dates
        $query->with('user')->whereHas('course',fn($q) => $q->DashboardTrainer());

        if (isset($request['req']['from']) && $request['req']['from'] != '') {
            $query->whereHas('order', fn($q) => $q->whereDate('created_at', '>=', $request['req']['from']));
        }

        if (isset($request['req']['to']) && $request['req']['to'] != '') {
            $query->whereHas('order', fn($q) => $q->whereDate('created_at', '<=', $request['req']['to']));
        }

        if (isset($request['req']['order_status_id']) && $request['req']['order_status_id'] != '') {
            $query->whereHas('order', fn($q) => $q->where('order_status_id', $request['req']['order_status_id']));
        }

        if (isset($request['req']['course_id']) && $request['req']['course_id'] != '') {
            $query->where('course_id', $request['req']['course_id']);
        }

        if (isset($request['req']['trainer_id']) && $request['req']['trainer_id'] != '') {
            $query->where('trainer_id', $request['req']['trainer_id']);
        }

        if (isset($request['req']['status']) && $request['req']['status'] == '1') {
            $query->active();
        }

        if (isset($request['req']['status']) && $request['req']['status'] == '0') {
            $query->unactive();
        }

        return $query;
    }

}
