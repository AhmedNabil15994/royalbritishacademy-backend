@extends('apps::frontend.layouts.app')
@section('title', $course->title)
@section('content')
<div class="course-head">
  <div class="container">
    <h1 class="inner-title">{{ $course->title }}</h1>
    <a class="tutor-name d-block" href="{{ route('frontend.trainers.show',$course->trainer->id) }}">{{ $course->trainer->name }}</a>
    <span>{{ $course->price}} {{ __('KWD') }}</span>
  </div>
</div>
<div class="grey-bg">
  <div class="container">
    <section class="course-content-area">
      <div class="row">
        <div class="col-md-7">
          <div class="class-description">
            <div class="description-box mb-30">
              <h3>{{ __('Description') }}</h3>
              {!! $course->description !!}
            </div>
            @if($course->targets->count()>0)
            <div class="whatyoulearn description-box mb-30 bg-white">
              <h3>{{ __('What you will Learn') }}</h3>
              <div class="row">
                @foreach($course->targets as $key => $target)
                <ul class="list-check col-md-6">
                  <li>{{$loop->iteration.'-'. $target->target }}</li>
                </ul>
                @endforeach
              </div>
            </div>
            @endif
            @include('course::frontend.courses.show-partials.content-wrapper')
            <div class="description-box mb-30">
              <h3>{{ __('Requirements') }}</h3>
              <p>
                {!! $course->requirements !!}
              </p>
            </div>
            @include('course::frontend.courses.show-partials.course-review')
          </div>
        </div>
        <div class="col-md-5">
          <div class="course-sidebar natural">
            <div class="preview-video-box position-relative">
              <img src="{{ asset($course->image)  }}" alt="" class="img-fluid">
              <a class="pulse-icon lesson_video video-btn" href="#" data-toggle="modal" data-target="#VideoPreviewModal"
                data-video-id="{{data_get($course,'video.video_link')}}">
                <i style="line-height: 60px" class="fa fa-play"></i>
              </a>
            </div>
            <div class="course-sidebar-text-box mt-40">
              <div class="class-desc-block d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                  <i class="fa fa-users"></i>
                  <h4>{{ __('Student complete this course') }}</h4>
                </div>
                <p> {{
                  $course->order_course_count<10 ?$course->id*1:$course->order_course_count}}</p>
              </div>
              <div class="class-desc-block d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                  <i class="fa fa-history"></i>
                  <h4>{{ __('Duration') }}</h4>
                </div>
                <p> {{ $course->class_time }} {{ __('Hours') }} </p>
              </div>

              @if($course->isFinished()&&$course->is_certificated||$course->is_subscribed == 1)
              <div class="class-desc-block d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                  <i class="fa fa-certificate"></i>
                  <h4>{{ __('get cirtifcation') }}</h4>
                </div>
                <p>
                  <a class="btn main-custom-btn" target="_blank" href="{{ route('frontend.course.certification',$course->id) }}">
                    @lang('get your certification')
                  </a>
                </p>
              </div>
              @endif
              <div id="test-play"></div>
              @if ($course->is_subscribed == 0)
              <a style=" margin: 20px; width: 100%;" href="{{route('frontend.cart.add',['course',$course->slug])}}" class="btn btn main-custom-btn">
                {{ __("Add To Cart") }}
              </a>
              @endif
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</div>



@stop

@include('course::frontend.courses.modals.video')

@push('scripts')
<script src="https://player.vdocipher.com/playerAssets/1.6.10/vdo.js"></script>
<script src="{{ asset('frontend/js/plyr.js') }}"></script>

<script>
  const player = new Plyr('.player');

    function pausePreview() {
        player.pause();
    }

</script>
<script>
  $(document).ready(function() {

        $('.lesson_video').on('click', function(e) {
            var video_id = $(this).data('video-id');
            var lesson_content_id = $(this).data('lesson-content-id');

            $.ajax({
               url: '{{url(route('frontend.videos'))}}',
               type: 'GET',
               data: {
                    video_id: video_id,
                    lesson_content_id: lesson_content_id
                 },
                 beforeSend: function() {
                    $(".player_video").html('<div class="preloader"><div class="boxplus-load"></div></div>');
                },
                success: function(data) {


                    // $('#test-play').html(data);
                    $('.player_video').html(data);
                }
                , complete: function(data) {
                }
            , });

        });

    });

</script>
@endpush
