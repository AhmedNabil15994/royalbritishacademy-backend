{!! field()->langNavTabs() !!}

<div class="tab-content">
  @foreach (config('laravellocalization.supportedLocales') as $code => $lang)
  <div class="tab-pane fade in {{ ($code == locale()) ? 'active' : '' }}" id="first_{{$code}}">
    {!! field()->text('title['.$code.']',
    __('course::dashboard.notes.form.title').'-'.$code ,
    $model->getTranslation('title' , $code),
    ['data-name' => 'title.'.$code]
    ) !!}
    {!! field()->ckEditor5('desc['.$code.']',
    __('course::dashboard.notes.form.description').'-'.$code ,
    $model->getTranslation('desc' , $code),
    ['data-name' => 'desc.'.$code]
    ) !!}
  </div>
  @endforeach
</div>


{!! field()->select('trainer_id',__('course::dashboard.notes.form.trainer'),$trainers->pluck('name','id'), null , )
!!}

{!! field()->file('image', __('course::dashboard.notes.form.image'),$model->id?$model->getFirstMediaUrl('images'):null) !!}

{!! field()->file('pdf', __('course::dashboard.notes.form.pdf'),$model->id?$model->getFirstMediaUrl('pdf'):null) !!}


{!! field()->checkBox('is_free', __('is free')) !!}

<div style="{{$model->is_free ? 'display:none' : ''}}" id="price_content">
{!! field()->number('price', __('course::dashboard.notes.form.price'),null,['step'=>'0.01']) !!}
</div>


{!! field()->checkBox('status', __('course::dashboard.notes.form.status')) !!}


@if ($model->trashed())
{!! field()->checkBox('trash_restore', __('course::dashboard.levels.form.restore')) !!}
@endif





@push('scripts')
<script type="text/javascript">
  $(function() {
        $('#jstree').jstree();

        $('#jstree').on("changed.jstree", function(e, data) {
            $('#root_category').val(data.selected);
        });
        
        $('#is_free').on('switchChange.bootstrapSwitch',function(event,hidden){
                $('#price_content').toggle();
            })
    });
</script>
@endpush
