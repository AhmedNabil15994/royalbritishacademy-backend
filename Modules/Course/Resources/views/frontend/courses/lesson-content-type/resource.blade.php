<li>
  <div class="course-details__curriculum-list-left">
    <div class="course-details__meta-icon file-icon">
      <i class="fas fa-folder"></i>
    </div>
    <a href="{{$lessonContent->resource_file}}">{{$lessonContent->title}}</a>
  </div>
  <div class="course-details__curriculum-list-right">
    <a onclick="downloadFile('{{$lessonContent->resource_file}}')" style="cursor: pointer">@lang("Download")</a>
  </div>
</li>
