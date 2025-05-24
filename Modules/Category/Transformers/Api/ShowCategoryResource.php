<?php

namespace Modules\Category\Transformers\Api;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Course\Transformers\Api\CourseCardResource;
use Modules\Course\Transformers\Api\NoteCardResource;
use Modules\Package\Transformers\Api\PackageCardResource;

class ShowCategoryResource extends JsonResource
{
    public function toArray($request)
    {
        return [
           'id'            => $this->id,
           'image'         => $this->getFirstMediaUrl('images'),
           'title'         => $this->title,
           'packages' => PackageCardResource::collection($this->packagePrices()->active()->get()),
           'notes' => NoteCardResource::collection($this->notes()->active()->get()),
           'courses' => CourseCardResource::collection($this->courses()->active()->orderBy('order','asc')->get()),
       ];
    }
}
