@extends('apps::frontend.layouts.app')
@section('title', $trainer->name)
@section('content')
<section class="page-head align-items-center text-center d-flex">
  <div class="container">
    <h1>{{ $trainer->name }}</h1>
  </div>
</section>
<div class="inner-page grey-bg">
  <div class="container">
    <div class="tutor-profile">
      <div class="row">
        <div class="col-md-8">
          <div class="tutor-details">
            <h3>{{ $trainer->name }}</h3>
            <p>{{ optional($trainer->profile)->job_title }}</p>
          </div>
          <div class="resume">
            @if($trainer?->profile?->about)
            <h2 class="inner-title theme-color">{{ __('My Resume') }}</h2>
            <p>{!! optional($trainer->profile)->about !!}</p>
            @endif
          </div>
        </div>
        <div class="col-md-4">
          <div class="tutor-personal-details text-center">
            <div class="img-block">
              <img class="img-fluid" src="{{ asset($trainer->image) }}" alt="" />
            </div>
            @if($trainer->course_reviews_count>0)
            <div class="star-rating d-block" data-rating="{{ $trainer->stars }}"></div>
            <span class="total-rate d-block">
              ( {{ $trainer->course_reviews_count }} )
            </span>
            @endif
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-9">
      <div class="courses-block">
        <div class="row">
          @foreach($trainer->courses as $key => $course)
          <div class="col-md-4 col-6 py-4">
            @includeIf('course::frontend.courses.components.single-course')
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</div>

@stop
