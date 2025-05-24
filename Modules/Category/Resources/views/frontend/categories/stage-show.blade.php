@extends('apps::frontend.layouts.app')
@section('content')
<section class="inner-banner">
  <div class="container">
    <ul class="list-unstyled thm-breadcrumb">
      <li><a href="{{ route('frontend.home') }}">{{ __('Home') }} </a></li>
      <li><a href="{{ route('frontend.categories.show',['category'=>$category->parent->id]) }}"> {{ $category->parent->title }}</a></li>
      <li class="active"><a href="{{ route('frontend.categories.show',['category'=>$category->id]) }}">{{ $category->title }}</a></li>
    </ul>
  </div>
</section>

<section class="course-one course-page bg-color-dark">
  <div class="container">
    @php $packages = $category->packages()->active()->get() @endphp
    @php $has_data = false @endphp
    @if(count($packages))
      @php $has_data = true @endphp
      <h2 class="header-title">
        <div class="course-details__meta-icon flag-icon"> <i class="fas fa-flag"></i></div> {{ __('Package') }}
      </h2>
      <div class="row">

        @foreach($packages as $package)
        <div class="col-lg-3">
          <a href="{{ route('frontend.packages.show',['package'=>$package->id]) }}">
            <div class="course-one__single">
              <div class="course-one__image">
                <img src="{{ $package->image }}" alt="">
              </div>
              <div class="course-one__content">
                <div class="course-one__category">{{ $category->title }} </div>
                <h2 class="course-one__title title-name">{{ $package->title }}</h2>
                <p>{{ $package->description }}</p>
              </div>
            </div>
          </a>
        </div>
        @endforeach
      </div>
      <hr>
    @endif

    @php $notes = $category->notes()->active()->get() @endphp
    @if(count($notes))
      @php $has_data = true @endphp
      <h2 class="header-title">
        <div class="course-details__meta-icon file-icon"> <i class="fas fa-folder"></i></div> {{ __('Printed Notes') }}
      </h2>
      <div class="row">
        @foreach($notes as $note)
          <div class="col-lg-3">
           @include("course::frontend.courses.notes.note-card")
          </div>
        @endforeach
      </div>
      <hr>
    @endif

    @php $courses = $category->courses()->active()->orderBy('order','asc')->get() @endphp
    @if(count($courses))
      @php $has_data = true @endphp
      <h2 class="header-title">
        <div class="course-details__meta-icon video-icon"> <i class="fas fa-play"></i></div> {{ __('Materials') }}
      </h2>
      <div class="row">
        @foreach($courses ??[] as $course)
          <div class="col-lg-3">
            <a href="{{ route('frontend.courses.show',['slug'=>$course->slug]) }}">
              <div class="course-one__single">
                <div class="course-one__image">
                  <img src="{{ asset($course->image) }}" alt="">
                </div>
                <div class="course-one__content">
                  <div class="course-one__category">{{ $category->title }} </div>
                  <h2 class="course-one__title title-name">{{ $course->title }}</h2>
                  <a href="{{ route('frontend.courses.show',['slug'=>$course->slug]) }}" class="course-one__link">{{ __('Show') }}</a>
                </div>
              </div>
            </a>
          </div>
        @endforeach
      </div>
    @endif

    @if(!$has_data)
      <div class="alert alert-danger" role="alert" style="text-align: center;">
        @lang("No Data Found")
      </div>
    @endif
  </div>
</section>

@endsection