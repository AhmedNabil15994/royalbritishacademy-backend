<?php

namespace Modules\Category\Transformers\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class MaterialResource extends JsonResource
{
    public function toArray($request)
    {
       return [
           'id'            => $this->id,
           'title'         => $this->title,
       ];
    }
}
