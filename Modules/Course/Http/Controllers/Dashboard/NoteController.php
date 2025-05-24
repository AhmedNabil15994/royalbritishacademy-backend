<?php

namespace Modules\Course\Http\Controllers\Dashboard;

use Modules\Course\Entities\Note;
use Illuminate\Routing\Controller;
use Modules\Course\Entities\Course;
use Modules\Core\Traits\Dashboard\CrudDashboardController;
use Modules\Course\Repositories\Dashboard\CourseVideoApiRepository;

class NoteController extends Controller
{
    use CrudDashboardController;

    public function notes()
    {

        $courses = Note::
            when(
                request('search'),
                fn ($q, $val) => $q->search($val)
            )
            ->when(
                request('category_id'),
                fn ($q, $val) => $q->whereCategoryId($val)
            )
            ->get();
        return  response()->json($courses);
    }
}
