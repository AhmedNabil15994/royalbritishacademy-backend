<li>
  <div class="course-details__curriculum-list-left">
    <div class="course-details__meta-icon video-icon">
      <i class="fas fa-play"></i>
    </div>
    @if($course->current_user_hasAccess)
      <a class="tablinks" id="defaultOpen" onclick="openVideo(event, 'vid-'+{{ $lessonContent->id }})" href="#">
        {{$lessonContent->title }}
      </a>
    @else
      <a class="tablinks" href="#">
        {{$lessonContent->title }}
      </a>
    @endif
  </div>
  <div class="course-details__curriculum-list-right">
    <input type="checkbox">
  </div>
</li>

