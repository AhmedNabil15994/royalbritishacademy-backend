<?php

namespace Modules\Course\Repositories\Dashboard;

use DB;
use Hash;
use Illuminate\Http\Request;
use Modules\Course\Entities\Lesson;
use Modules\Course\Entities\CourseLesson;
use Modules\Core\Traits\Attachment\Attachment;
use Modules\Core\Traits\RepositorySetterAndGetter;
use Modules\Core\Repositories\Dashboard\CrudRepository;

class LessonRepository extends CrudRepository
{
    public function __construct()
    {
        parent::__construct(Lesson::class);
        $this->fileAttribute = ['image' => 'image'];
    }

    public function getModel()
    {
        return $this->model
            ->when(
                request('course_id'),
                fn ($q, $v) =>  $q->whereCourseId($v)
            );
    }

    public function filterDataTable($query, $request)
    {
        $query = parent::filterDataTable($query, $request);

        return $query
            ->when(
                data_get($request, 'req.semester_id'),
                fn ($q, $v) => $q->where('semester_id', $v)
            )->when(
                data_get($request, 'req.course_id'),
                fn ($q, $v) => $q->where('course_id', $v)
            );
    }
}
