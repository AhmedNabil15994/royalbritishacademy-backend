<?php

namespace Modules\Trainer\Transformers\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class ApplyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'            => $this->id,
            'name'          => $this->name,
            'email'         => $this->email,
            'mobile'        => $this->mobile,
            'cv'            => $this->getFirstMediaUrl('cv'),
            'created_at'    => date('d-m-Y', strtotime($this->created_at)),

        ];
    }
}
