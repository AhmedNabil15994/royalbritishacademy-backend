@auth()
  <a onclick="submitCourseForm(this,'course{{$course->id}}')" class="course-one__link">{{ __('Buy') }}</a>
  {!! Form::open([
      'url'=> route('frontend.courses.buy',$course->id),
      'role'=>'form',
      'class'=>'packages_form',
      'id'=>'course'. $course->id,
      'method'=>'POST',
      ])!!}{!! Form::close()!!}
@else
  <a href="{{route('frontend.auth.login')}}" class="course-one__link">{{ __('Buy') }}</a>
@endauth