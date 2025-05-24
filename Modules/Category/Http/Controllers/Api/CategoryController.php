<?php

namespace Modules\Category\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Category\Entities\Material;
use Modules\Category\Transformers\Api\{CategoryResource,MaterialResource};
use Modules\Slider\Repositories\Api\SliderRepository as Slider;
use Modules\Category\Repositories\Api\CategoryRepository as Category;
use Modules\Apps\Http\Controllers\Api\ApiController;
use Modules\Slider\Transformers\Api\SliderResource;

class CategoryController extends ApiController
{
    private $category;

    function __construct(Category $category, public Slider $slider)
    {
        if (request()->hasHeader('authorization'))
            $this->middleware('auth:sanctum');

        $this->category = $category;
    }

    public function categories(Request $request)
    {
        return CategoryResource::collection($this->category->getAllCategories($request));

    }

    public function materials(Request $request)
    {
        $materials = Material::active()->orderBy('title->'.locale(),'asc')->get();
        return MaterialResource::collection($materials);
    }
}
