@if($model->id)
<div>
  @if($model?->video?->video_status == 'loaded')
  {!! $extraData['video_view'] !!}
  @endif
</div>
@endif
