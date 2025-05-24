@inject('semesters', 'Modules\Semester\Entities\Semester')
@inject('courses', 'Modules\Course\Entities\Course')


<div class="col-md-4">
  {!! field()->select('semester_id',__('course::dashboard.lessons.form.semesters') ,$semesters->active()->pluck('title','id'),request('semester_id'), ) !!}
</div>


<div class="col-md-4">
  {!! field()->select('course_id',__('course::dashboard.lessons.form.courses') ,$courses->active()->pluck('title','id'),request('course_id'), ) !!}
</div>
