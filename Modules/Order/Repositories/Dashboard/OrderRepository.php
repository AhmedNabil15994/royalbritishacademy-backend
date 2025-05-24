<?php

namespace Modules\Order\Repositories\Dashboard;

use Modules\Core\Traits\RepositorySetterAndGetter;
use Modules\Order\Entities\Order;
use DB;
use Auth;

class OrderRepository
{
    use RepositorySetterAndGetter;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function monthlyOrders()
    {
        $data["orders_dates"] = $this->order->whereHas('courses',fn($q) => $q->DashboardTrainer())->whereHas('orderStatus', function ($query) {
            $query->successPayment();
        })
            ->select(\DB::raw("DATE_FORMAT(created_at,'%Y-%m') as dates"))
            ->groupBy('dates')
            ->pluck('dates');

        $ordersIncome = $this->order->whereHas('courses',fn($q) => $q->DashboardTrainer())->whereHas('orderStatus', function ($query) {
            $query->successPayment();
        })
            ->select(\DB::raw("sum(total) as profit"))
            ->groupBy(\DB::raw("DATE_FORMAT(created_at, '%Y-%m')"))
            ->get();

        $data["profits"] = json_encode(array_pluck($ordersIncome, 'profit'));

        return $data;
    }

    public function ordersType()
    {
        $orders = $this->order->whereHas('courses',fn($q) => $q->DashboardTrainer())
            ->with('orderStatus')
            ->select("order_status_id", \DB::raw("count(id) as count"))
            ->groupBy('order_status_id')
            ->get();


        foreach ($orders as $order) {
            $status = $order->orderStatus->title;
            $order->type = $status;
        }

        $data["ordersCount"] = json_encode(array_pluck($orders, 'count'));
        $data["ordersType"] = json_encode(array_pluck($orders, 'type'));

        return $data;
    }

    public function completeOrders()
    {
        $orders = $this->order->whereHas('courses',fn($q) => $q->DashboardTrainer())->whereHas('orderStatus', function ($query) {
            $query->successPayment();
        })->count();

        return $orders;
    }

    public function totalProfit()
    {
        return $this->order->whereHas('courses',fn($q) => $q->DashboardTrainer())->whereHas('orderStatus', function ($query) {
            $query->successPayment();
        })->sum('total');
    }

       public function totalTodayProfit()
    {
        return $this->order->whereHas('courses',fn($q) => $q->DashboardTrainer())->whereHas('orderStatus', function ($query) {
            $query->successPayment();
        })
            ->whereDate("created_at", \DB::raw('CURDATE()'))
            ->sum('total');
    }


    public function totalMonthProfit()
    {
        return $this->order->whereHas('courses',fn($q) => $q->DashboardTrainer())->whereHas('courses',fn($q) => $q->DashboardTrainer())->whereHas('orderStatus', function ($query) {
            $query->successPayment();
        })
            ->whereMonth("created_at", date("m"))
            ->whereYear("created_at", date("Y"))
            ->sum('total');
    }

       public function totalYearProfit()
    {
        return $this->order->whereHas('courses',fn($q) => $q->DashboardTrainer())->whereHas('orderStatus', function ($query) {
            $query->successPayment();
        })
            ->whereYear("created_at", date("Y"))
            ->sum('total');
    }

    public function getAll($order = 'id', $sort = 'desc')
    {
        $orders = $this->order->whereHas('courses',fn($q) => $q->DashboardTrainer())->orderBy($order, $sort)->get();
        return $orders;
    }

    public function findById($id)
    {
        $order = $this->order->whereHas('courses',fn($q) => $q->DashboardTrainer())->withDeleted()->find($id);

        return $order;
    }

    public function update($request, $id)
    {
        $order = $this->findById($id);

        $order->update([
            'order_status_id' => $request['status_id'],
            'date' => $request['date'],
            'delivery_time' => $request['time'],
        ]);

        return true;
    }

    public function updateUnread($id)
    {
        $order = $this->findById($id);

        $order->update([
            'unread' => true,
        ]);
    }

    public function updateDriver($request, $id)
    {
        $order = $this->findById($id);

        $order->driver()->updateOrCreate([
            'user_id' => $request['user_id'],
        ]);

        return true;
    }

    public function restoreSoftDelete($model)
    {
        $model->restore();
    }

    public function delete($id)
    {
        DB::beginTransaction();

        try {
            $model = $this->findById($id);

            if ($model->trashed()):
                $model->forceDelete(); else:
                $model->delete();
            endif;

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function deleteSelected($request)
    {
        DB::beginTransaction();

        try {
            foreach ($request['ids'] as $id) {
                $model = $this->delete($id);
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function QueryTable($request)
    {
        $query = $this->order->with('user')->whereHas('user',function ($query) use ($request){
                $query->where('name', 'like', '%' . $request->input('search.value') . '%');
                $query->orWhere('email', 'like', '%' . $request->input('search.value') . '%');
                $query->orWhere('mobile', 'like', '%' . $request->input('search.value') . '%');
            })->whereHas('courses',fn($q) => $q->DashboardTrainer())->where(function ($query) use ($request) {
//                $query->where('id', 'like', '%' . $request->input('search.value') . '%');
            });

        $query = $this->filterDataTable($query, $request);

        return $query;
    }

    public function filterDataTable($query, $request)
    {
        if (isset($request['req']['from']) && $request['req']['from'] != '') {
            $query->whereDate('created_at', '>=', $request['req']['from']);
        }

        if (isset($request['req']['to']) && $request['req']['to'] != '') {
            $query->whereDate('created_at', '<=', $request['req']['to']);
        }

        if (isset($request['req']['deleted']) && $request['req']['deleted'] == 'only') {
            $query->onlyDeleted();
        }

        if (isset($request['req']['deleted']) && $request['req']['deleted'] == 'with') {
            $query->withDeleted();
        }

        if (isset($request['req']['status']) && $request['req']['status'] == '1') {
            $query->active();
        }

        if (isset($request['req']['status']) && $request['req']['status'] == '0') {
            $query->unactive();
        }

        if (isset($request['req']['worker_id'])) {
            $query->where('worker_id', $request['req']['worker_id']);
        }

        if (isset($request['req']['status_id'])) {
            $query->where('order_status_id', $request['req']['status_id']);
        }

        if (isset($request['req']['course_id'])) {
            $query->whereHas('orderCourses', function ($q) use ($request) {
                $q->where('course_id', $request['req']['course_id']);
            });
        }

        if (isset($request['req']['course_type'])) {
            $query->whereHas('orderCourses', function ($query) use ($request) {
                $query->whereHas('course', function ($query) use ($request) {
                    $query->where('is_online', $request['req']['course_type']);
                });
            });
        }

        if (isset($request->status_id)) {
            $query->where('order_status_id', $request->status_id);
        }
        return $query;
    }
}
