<?php

namespace Modules\Package\Http\Controllers\Dashboard;


use Illuminate\Support\Arr;
use Illuminate\Routing\Controller;
use Modules\Core\Traits\Dashboard\CrudDashboardController;
use Modules\Category\Repositories\Dashboard\CategoryRepository;
use Modules\Package\Transformers\Dashboard\PackagePricesResource;

class PackageController extends Controller
{
    use CrudDashboardController;

    use CrudDashboardController {
        CrudDashboardController::__construct as private __tConstruct;
    }

    public function __construct(public CategoryRepository $categoryRepository)
    {
        $this->__tConstruct();
    }

    public function extraData($model)
    {
        $categories = $this->categoryRepository->mainCategories()->transform(function ($category) {
            return [
                '' => [__('package::dashboard.suspensions.form.categories')],
                $category->title  =>  $category->children->pluck('title', 'id')
            ];
        });

        return [
            'model'          => $model,
            'categories'     => Arr::collapse($categories),
            'package_prices' => PackagePricesResource::collection($model->prices)->jsonSerialize(),
        ];
    }



   
}
