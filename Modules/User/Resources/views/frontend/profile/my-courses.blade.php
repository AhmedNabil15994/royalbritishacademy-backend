@extends('apps::frontend.layouts.app')
@section('title', __('My Materials') )
@section('content')
<section class="inner-banner">
  <div class="container">
    <ul class="list-unstyled thm-breadcrumb">
      <li><a href="{{ route('frontend.home') }}">{{ __('Home') }} </a></li>
      <li class="active"><a href="#">@lang("My Materials")</a></li>
    </ul>
  </div>
</section>

<section class="course-details account print-file bg-color-dark">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <section class="course-one items course-page bg-color-dark">
                    <div class="container">
                        <div class="row">
                            @foreach ($courses as $course)
                                <div class="col-lg-4">
                                    <a href="{{ route('frontend.courses.show',['slug'=>$course->slug]) }}">
                                        <div class="course-one__single">
                                        <div class="course-one__image">
                                            <img src="{{ asset($course->image) }}" alt="">
                                        </div>
                                        <div class="course-one__content">
                                            <div class="course-one__category">{{ $course->categories()?->first()?->title }} </div>
                                            <h2 class="course-one__title title-name">{{ $course->title }}</h2>
                                        </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </section>
            </div>
            
            <div class="col-lg-4">
                @include("user::frontend.profile.components.sidebar")
            </div>
        </div>
    </div>
</section>

@stop
