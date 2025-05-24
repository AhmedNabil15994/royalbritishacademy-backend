@inject('exams' ,'Modules\Exam\Entities\Exam')

{!! field()->langNavTabs() !!}
<div class="tab-content">
    @foreach (config('laravellocalization.supportedLocales') as $code => $lang)
    <div class="tab-pane fade in {{ ($code == locale()) ? 'active' : '' }}" id="first_{{$code}}">
        {!! field()->text('question['.$code.']',
        __('exam::dashboard.questions.form.question').'-'.$code ,
        $model->getTranslation('question' , $code),
        ['data-name' => 'question.'.$code]
        ) !!}
    </div>
    @endforeach
</div>


{!! field()->select('exam_id',__('exam::dashboard.questions.form.exams'),$exams->pluck('title','id')->toArray()) !!}







{!!
   field()->checkBox('with_file',
    __('exam::dashboard.questions.form.with-audio'),'on',
      ['checked'=> $model->type=='audio'?'checked':false]
      )
!!}
<div class="with-file"
    {{
    $model->type!='audio'?'hidden':'' }} >
   {!! field()->file('audio', __('exam::dashboard.questions.form.audio')) !!}
@if( $model->type=='audio')
   <audio controls autoplay>
    <source src="{{ $model->getFirstMediaUrl('audio') }}" type="audio/ogg">
   </audio>
@endif
</div>


{!! field()->file('image', __('exam::dashboard.questions.form.image'), $model->getFirstMediaUrl('images')) !!}


@push('scripts')
<script>
    let options={
            '#with_file':'with-file',
        }

        for (const key in options) {
            $(key).on('switchChange.bootstrapSwitch',function(event,hidden){
                $(`.${options[key]}`).attr('hidden',!hidden)
                $(`.${options[key]}`).find(`#${options[key]}`).attr('disabled',!hidden)
            })
        }

</script>
@endpush

