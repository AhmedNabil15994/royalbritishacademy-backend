{!! field()->langNavTabs() !!}

<div class="tab-content">
    @foreach (config('laravellocalization.supportedLocales') as $code => $lang)
    <div class="tab-pane fade in {{ ($code == locale()) ? 'active' : '' }}"
        id="first_{{$code}}">
        {!! field()->text('job_title['.$code.']',
        __('trainer::dashboard.trainers.create.form.job_title').'-'.$code ,
        optional( $model->profile)->getTranslation('job_title',$code),
        ['data-name' => 'job_title.'.$code]
        ) !!}

        {!! field()->text('country['.$code.']',
        __('trainer::dashboard.trainers.create.form.country').'-'.$code ,
        optional($model->profile)->getTranslation('country',$code),
        ['data-name' => 'country.'.$code]
        ) !!}

        {!! field()->ckEditor5('about['.$code.']',
        __('trainer::dashboard.trainers.create.form.about').'-'.$code ,
        optional($model->profile)->getTranslation('about',$code),
        ['data-name' => 'about.'.$code]
        ) !!}
    </div>
    @endforeach
</div>
