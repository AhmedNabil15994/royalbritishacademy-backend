<div class="description-box mb-30">
  <h3>{{ __('Course Content ') }}</h3>
  <div class="course-curriculum-box mt-20">
    <div class="course-curriculum-accordion">

      @include('course::frontend.courses.show-partials.course-content')
      {{-- @if ($course->is_subscribed == 0)
      @include('course::frontend.courses.show-partials.subscriped-link')
      @endif --}}
    </div>
  </div>
</div>
