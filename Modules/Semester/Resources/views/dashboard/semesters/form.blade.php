{!! field()->langNavTabs() !!}
<div class="tab-content">
  @foreach (config('laravellocalization.supportedLocales') as $code => $lang)
  <div class="tab-pane fade in {{ ($code == locale()) ? 'active' : '' }}" id="first_{{$code}}">
    {!! field()->text('title['.$code.']',
    __('semester::dashboard.semesters.form.title').'-'.$code ,
    $model->getTranslation('title' , $code),
    ['data-name' => 'title.'.$code]
    ) !!}
  </div>
  @endforeach
</div>


{!! field()->number('order', __('course::dashboard.lessoncontents.form.order')) !!}

{{-- {!! field()->checkBox('is_news', __('semester::dashboard.semesters.form.is_news')) !!} --}}
{!! field()->checkBox('status', __('semester::dashboard.semesters.form.status')) !!}

@if ($model->trashed())
{!! field()->checkBox('trash_restore', __('apps::dashboard.datatable.form.restore')) !!}
@endif
