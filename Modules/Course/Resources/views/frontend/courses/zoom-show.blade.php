@extends('apps::frontend.layouts.app')
@section('title', $course->title)
@push("styles")
<link type="text/css"
    rel="stylesheet"
    href="https://source.zoom.us/2.3.0/css/bootstrap.css" />
<link type="text/css"
    rel="stylesheet"
    href="https://source.zoom.us/2.3.0/css/react-select.css" />


@endpush
@section('content')
<div class="course-head">
    <div class="container">
        <h1 class="inner-title">{{ $course->title }}</h1>
        <a class="tutor-name d-block"
            href="{{ route('frontend.trainers.show',$course->trainer->id) }}">{{ $course->trainer->name }}</a>
    </div>
</div>
<div class="grey-bg">
    <div class="container">

                <div id="appVue">
                    <zoom-client url-signature="{{route('frontend.api.generate')}}"
                        meeting-number="{{$course->meeting->zoom_response->get('id')}}"
                        role="{{ $course->trainer_id==auth()->id()?'1':'0'}}"
                        user-name="{{ auth()->user()->name }}" />
                </div>

    </div>
</div>



@stop


@push('scripts')
<script src="{{url('js/course.js')}}"></script>
@endpush
