<?php

namespace Modules\Notification\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Notification\Transformers\Dashboard\NotificationResource;
use Modules\Core\Traits\DataTable;
use Modules\Notification\Http\Requests\Dashboard\NotificationRequest;
use Modules\Notification\Repositories\Dashboard\NotificationRepository as Notification;
use Modules\Notification\Traits\SendNotificationTrait as SendNotification;

class NotificationController extends Controller
{
    use SendNotification;

    public $notification;

    public function __construct(Notification $notification)
    {
        $this->notification = $notification;
    }

    public function index()
    {
        return view('notification::dashboard.notifications.index');
    }

    public function datatable(Request $request)
    {
        $datatable = DataTable::drawTable($request, $this->notification->QueryTable($request));
        $datatable['data'] = NotificationResource::collection($datatable['data']);
        return Response()->json($datatable);
    }

    public function notifyForm()
    {
        return view('notification::dashboard.notifications.create');
    }

    public function push_notification(NotificationRequest $request)
    {

        try {
            $notification = $this->notification->create($request);

            $tokens = $this->notification->getAllFcmTokens();
            if (count($tokens)) {
                foreach($tokens as $lang => $token){
                    $data = [
                        'title' => isset($request['title'][$lang]) ? $request['title'][$lang] : '',
                        'body' => isset($request['body'][$lang]) ? $request['body'][$lang] : '',
                    ];
                    $data['type'] = 'general';
                    $data['id'] = null;
                    $this->send($data, (array)$token);
                }
            }

            return Response()->json([true, __('notification::dashboard.notifications.general.message_sent_success')]);
        } catch (\Exception $e) {
            return Response()->json([false, __('apps::dashboard.general.message_error')]);
        }
    }

    public function destroy($id)
    {
        try {
            $delete = $this->notification->delete($id);

            if ($delete) {
                return Response()->json([true, __('apps::dashboard.general.message_delete_success')]);
            }

            return Response()->json([false, __('apps::dashboard.general.message_error')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function deletes(Request $request)
    {
        try {
            $deleteSelected = $this->notification->deleteSelected($request);

            if ($deleteSelected) {
                return Response()->json([true, __('apps::dashboard.general.message_delete_success')]);
            }

            return Response()->json([false, __('apps::dashboard.general.message_error')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }
}
