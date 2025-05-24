{!! field()->langNavTabs() !!}

<div class="tab-content">
    @foreach (config('laravellocalization.supportedLocales') as $code => $lang)
    <div class="tab-pane fade in {{ ($code == locale()) ? 'active' : '' }}" id="first_{{$code}}">
        {!! field()->text('title['.$code.']',
        __('area::dashboard.cities.form.title').'-'.$code ,
        $model->getTranslation('title' , $code),
        ['data-name' => 'title.'.$code]
        ) !!}
    </div>
    @endforeach
</div>

{!! field()->number('degree', __('exam::dashboard.exams.form.degree')) !!}
{!! field()->number('success_degree', __('exam::dashboard.exams.form.success_degree')) !!}
{!! field()->number('duration', __('exam::dashboard.exams.form.duration')) !!}

@if ($model->trashed())
{!! field()->checkBox('trash_restore', __('exma::dashboard.exmas.form.restore')) !!}
@endif


