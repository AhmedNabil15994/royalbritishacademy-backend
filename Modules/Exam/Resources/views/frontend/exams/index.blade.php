@extends('apps::frontend.layouts.app')

@section('title',__('English Level Test'))
@section('content')
<section class="page-head align-items-center text-center d-flex">
    <div class="container">
        <h1>{{ __('English Level Test') }}</h1>
    </div>
</section>
<div class="inner-page grey-bg">
    <div class="container">
        <div class="levels-page">
            <h2 class="inner-title text-center mb-60">
                {{
                __('Find out which Edutain English exam may be best for you. Take our quick, free online test.')
                 }}
            </h2>
            <div class="course-levels d-flex align-items-center justify-content-center">
                @foreach($exams as $key => $exam)
                <a class="level-block" href="{{ route('frontend.exams.show',$exam->id) }}">
                    <h3>{{ $exam->title }}</h3>
                </a>
                @endforeach
            </div>
        </div>

    </div>
</div>
@endsection
