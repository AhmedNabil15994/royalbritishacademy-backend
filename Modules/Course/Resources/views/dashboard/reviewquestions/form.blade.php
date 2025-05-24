{!! field()->langNavTabs() !!}
<div class="tab-content">
  @foreach (config('laravellocalization.supportedLocales') as $code => $lang)
  <div class="tab-pane fade in {{ ($code == locale()) ? 'active' : '' }}" id="first_{{$code}}">
    {!! field()->text('title['.$code.']',
    __('course::dashboard.reviewquestions.form.title').'-'.$code ,
    $model->getTranslation('title' , $code),
    ['data-name' => 'title.'.$code]
    ) !!}
  </div>
  @endforeach
</div>








{!! field()->checkBox('status', __('course::dashboard.reviewquestions.form.status')) !!}

@if ($model->trashed())
{!! field()->checkBox('trash_restore', __('course::dashboard.reviewquestions.form.restore')) !!}
@endif
