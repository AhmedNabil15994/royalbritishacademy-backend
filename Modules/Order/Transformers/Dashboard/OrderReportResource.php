<?php

namespace Modules\Order\Transformers\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;
use IlluminateAgnostic\Collection\Support\Carbon;

class OrderReportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $orderStatus = $this->order?->orderStatus;
         return [
            'id' => $this->id,
            'course_id' => $this->course?->title,
            'order_id' => "<a href='".(route('dashboard.orders.show',$this->order_id))."'>{$this->order_id}</a>",
            'total' => $this->total,
            'status' => "<span class='badge badge-{$orderStatus?->color_label}'>{$orderStatus?->title}</span>",
            'trainer' => $this->course?->trainer?->name,
            'student_name' => ($this->order?->user?->name ?? ''),
            'student_mobile' =>  ($this->order?->user?->mobile ?? ""),
            'created_at' => $this->order?->created_at ? Carbon::parse($this->order?->created_at)->toDateString() : '',
        ];
    }
}
