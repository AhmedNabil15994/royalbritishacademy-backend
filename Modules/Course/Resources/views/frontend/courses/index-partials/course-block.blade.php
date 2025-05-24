<div class="{{ $wrapperClass }}">
  <div class="course-block">
    <div class="img-block">
      <img class="img-fluid" src="{{ asset($course->image) }}">
    </div>
    <div class="course-content">
      <h3><a class="btn" href="{{ route('frontend.courses.show',$course->slug) }}">{{ $course->title }}</a></h3>
      <div class="d-flex align-items-center justify-content-between">
        <a class="" href="{{ route('frontend.trainers.show',$course->trainer->id) }}">{{ $course->trainer->name }}</a>
        <span class="course-users"><i class="fas fa-users"></i> {{
          $course->order_course_count<10 ?$course->id:$course->order_course_count
            }}</span>
      </div>
      <div class="star-rating" data-rating="{{ $course->stars}}"></div>
      <div class="d-flex align-items-center justify-content-between">
        <span>{{ $course->price}} {{ __('KWD') }}</span>
        @if ($course->subscribed()->count() <= 0) <a class="btn  main-custom-btn add-cart" href="{{route('frontend.cart.add',['course',$course->slug])}}">{{
          __('Add To Cart') }}
          </a>
          @endif
      </div>
    </div>
  </div>
</div>
