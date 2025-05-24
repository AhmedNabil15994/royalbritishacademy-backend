@extends('apps::frontend.layouts.app')
@section('title', __('Our Team') )
@section('content')
<section class="page-head align-items-center text-center d-flex">
    <div class="container">
        <h1>{{ __('Our Team') }}</h1>
    </div>
</section>
<div class="inner-page grey-bg">
    <div class="container">
        <div class="row">
            @foreach ($trainers as $trainer)
            <div class="col-md-3 col-6">
                <div class="team-block bg-white text-center">
                    <div class="img-block">
                        <img class="img-fluid"
                            src="{{url($trainer->image)}}"
                            alt="" />
                    </div>
                    <h3>{{ $trainer->name }}</h3>
                    <p class="position">{{ optional($trainer->profile)->job_title }}</p>
                    <a class="btn btn main-custom-btn"
                        href="{{ url(route('frontend.trainers.show',$trainer->id)) }}">{{ __('View Profile') }}</a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>


@stop
