<?php

namespace Modules\Semester\Repositories\Frontend;

use Modules\Semester\Entities\Semester;

class SemesterRepository
{
    public function __construct(Semester $semester)
    {
        $this->semester   = $semester;
    }

    public function getAllSemesters($order = 'order', $sort = 'asc')
    {
        $semesters = $this->semester->active()->orderBy($order, $sort)->get();

        return $semesters;
    }

    public function currentSemester()
    {
        $query = $this->semester->active();

        $ses = request('semester_id') ? $query->find(request('semester_id')) : 
        $query->find(setting('default_semester') ?? 1);
        
        return $ses;
    }
}
