@foreach($course->lessons as $key => $lesson)
<div class="lecture-group-wrapper">
  <div class="lecture-group-title d-flex collapsed" data-toggle="collapse" data-target="#collapse6" aria-expanded="false">
    <div class="title flex-1">
      {{ $lesson->title }}
    </div>
  </div>
  <div id="collapse6" class="lecture-list collapse show">
    <h3 style="margin-top: 11px;">{{ __('watch now') }}</h3>
    <ul>
      @foreach($lesson->lessonContents as $key => $lessonContent)
      @if($course->is_subscribed==1)
      @if($lessonContent->type=='video')
      <li data-toggle="modal" data-target="#VideoPreviewModal" class="lecture has-preview lesson_video video-btn"
        data-lesson-content-id="{{ $lessonContent?->video?->id }}" data-video-id="{{ $lessonContent?->video?->video_link}}">
        <span class="lecture-title"> {{ $lessonContent->title }}</span>
        <span class="lecture-time"> {{ $lessonContent?->video?->video_minutes
          }} </span>
      </li>
      @elseif($lessonContent->type=='resource')
      <li style="
          padding: 12px 20px 12px 0;
    position: relative;
    cursor: pointer;
    display: flex;
    justify-content: space-between;
          ">
        <a href="{{ $lessonContent->getFirstMediaUrl('resources') }}" target="_blank">
          <i class="fa fa-file"></i> <span class="lecture-title"> {{ $lessonContent->title }}</span>
        </a>
      </li>
      @endif
      @else
      @if($lessonContent->type=='video')
      <li class="lecture has-preview lesson_video video-btn disabled">
        <span class=""> {{ $lessonContent->title }} <i class="fa fa-lock"></i></span>
        <span class="lecture-time">{{ $lessonContent->video->video_minutes??0}} </span>
      </li>
      @elseif($lessonContent->type=='resource')
      <li style="padding: 12px 20px 12px 0;position: relative;cursor: pointer;display: flex;justify-content: space-between;">
        <span class=""> {{ $lessonContent->title }} <i class="fa fa-lock"></i></span>
      </li>
      @endif
      @endif
      @endforeach
    </ul>
  </div>
</div>
@endforeach
