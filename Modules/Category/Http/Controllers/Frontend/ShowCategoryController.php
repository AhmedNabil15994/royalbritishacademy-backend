<?php

namespace Modules\Category\Http\Controllers\Frontend;

use Illuminate\Routing\Controller;
use Modules\Category\Entities\Category;
use Modules\Core\Traits\Dashboard\CrudDashboardController;

class ShowCategoryController extends Controller
{
    public function __invoke(Category $category)
    {
        if ($category->category_id == null) {
            return view('category::frontend.categories.show', ['category' => $category->load('children')]);
        }
        return view('category::frontend.categories.stage-show', ['category' => $category->load('courses', 'notes', 'packages')]);
    }
}
