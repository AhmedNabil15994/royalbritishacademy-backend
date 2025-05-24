@inject('semesters', 'Modules\Semester\Entities\Semester')
{!! field()->langNavTabs() !!}
<div class="tab-content">
  @foreach (config('laravellocalization.supportedLocales') as $code => $lang)
  <div class="tab-pane fade in {{ ($code == locale()) ? 'active' : '' }}" id="first_{{$code}}">
    {!! field()->text('title['.$code.']',
    __('course::dashboard.lessons.form.title').'-'.$code ,
    $model->getTranslation('title' , $code),
    ['data-name' => 'title.'.$code]
    ) !!}
    {{-- {!! field()->textarea('desc['.$code.']',
    __('course::dashboard.lessons.form.desc').'-'.$code ,
    $model->getTranslation('desc' , $code),
    ['data-name' => 'desc.'.$code]
    ) !!} --}}

  </div>
  @endforeach
</div>

{!! field()->select('course_id',__('course::dashboard.lessons.form.courses') , $courses->pluck('title','id'),$model->course_id??request('course_id') ) !!}

{!! field()->select('semester_id',__('course::dashboard.lessons.form.semesters') , $semesters->active()->pluck('title','id') ) !!}

{!! field()->number('order', __('course::dashboard.lessoncontents.form.order')) !!}
{!! field()->file('image', __('course::dashboard.courses.form.image'),$model->image?asset($model->image):null) !!}
{!! field()->checkBox('status', __('course::dashboard.courses.form.status')) !!}




@if ($model->trashed())
{!! field()->checkBox('trash_restore', __('course::dashboard.levels.form.restore')) !!}
@endif
