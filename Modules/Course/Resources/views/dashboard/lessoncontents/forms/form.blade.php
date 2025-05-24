@if(! auth()->user()->can('trainer_access') && auth()->user()->can('dashboard_access'))
  @inject('courses', 'Modules\Course\Entities\Course')
@else
  @php $courses = Modules\Course\Entities\Course::DashboardTrainer(); @endphp
@endif

@foreach (config('laravellocalization.supportedLocales') as $code => $lang)
  <div class="tab-pane fade in {{ ($code == locale()) ? 'active' : '' }}" id="first_{{$code}}">
    {!! field()->text('title['.$code.']',
    __('course::dashboard.lessoncontents.form.title').'-'.$code ,
    $model->getTranslation('title' , $code),
    ['data-name' => 'title.'.$code]
    ) !!}

  </div>
  @endforeach

{!! field()->select('course_id',__('course::dashboard.lessons.datatable.course') , $courses->pluck('title','id')->toArray(),$model->course_id??request('course_id') ) !!}



{!! field()->number('order', __('course::dashboard.lessoncontents.form.order')) !!}
{!! field()->file('video', __('course::dashboard.lessoncontents.form.types.video')) !!}

@if ($model?->video?->loading_status == 'loaded')
    {!! $model->video->buildVideo() !!}
@elseif($model?->video?->loading_status == 'processing')

<div class="alert alert-warning" role="alert">
  @lang("Video is Processing")....
</div>
@endif
<br>
<br>
{!! field()->multiFileUpload('resources', __('course::dashboard.lessoncontents.form.types.pdf_files')) !!}

@if(count($model->getMedia('resources')))

    <div class="card col-md-9">
        <ul class="list-group list-group-flush">
        @foreach($model->getMedia('resources') as $media)
            <li class="list-group-item"  id="attach-{{$media->id}}">

                <a href="{{$media->getUrl()}}" title="عرض" target="blanck">
                    <i class="fa fa-file"></i>
                    {{$media->name}}
                </a>
                <a href="javascript:;" style="float: {{locale() == 'ar' ? 'left' : 'right'}};"
                 onclick="deleteRow('{{route('dashboard.lessoncontents.resources.delete',[$model->id,'resources',$media->id])}}','attach-{{$media->id}}')"
                     class="btn btn-danger btn-xs">
                    <i class="fa fa-trash"></i>
                </a>
            </li>
        @endforeach
        </ul>
    </div>
@endif
<div class="clearfix"></div>
{!! field()->checkBox('status', __('course::dashboard.courses.form.status')) !!}

<input type="hidden" class="set" name="type" value="video">

@push('scripts')
<script>
  $("[name='type']").on('change',function(){
          const type=$(this).val();
          hideAll(["#resource_wrap","#exam_id_wrap",'#video_wrap'])
          $(`#${type}_wrap`).show()
          $(`#${type}_id_wrap`).show()
        }).change()

        function hideAll(hideItems){
            hideItems.forEach(function(item){
                 $(item).hide()
             })
          }
</script>

@endpush
