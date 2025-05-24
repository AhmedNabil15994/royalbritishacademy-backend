<?php

namespace Modules\Order\Http\Controllers\Dashboard;

use Illuminate\Routing\Controller;
use Modules\Core\Traits\DataTable;
use Illuminate\Http\Request;
use Modules\Core\Traits\Dashboard\CrudDashboardController;

class OrderReportController extends Controller
{
    use CrudDashboardController {
        CrudDashboardController::__construct as private __tConstruct;
    }

    public function __construct()
    {
        $this->__tConstruct();
        $this->setViewPath("order::dashboard.orders-reports");
    }


    public function datatable(Request $request)
    {
        $query = $this->query($request);

        $total = $this->buildTotals($query);

        $datatable = DataTable::drawTable($request, $query);

        $resource = $this->model_resource;
        $datatable['data'] = $resource::collection($datatable['data'])->add($total);

        return Response()->json($datatable);
    }

    public function query(Request $request)
    {
        return $this->repository->QueryTable($request);
    }

    public function buildTotals($query)
    {
        $total = $query;
        $total = $total->sum('total');

        return [
            'id' => '----',
            'order_id' => __('Total'),
            'course_id' => '----',
            'total' => number_format($total,3) ,
            'status' => '----',
            'trainer' => '----',
            'created_at' => '----',
            'student_name' => '----',
            'student_mobile' => '----',
        ];
    }
}
