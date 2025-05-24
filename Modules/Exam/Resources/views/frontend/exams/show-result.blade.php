@extends('apps::frontend.layouts.app')
@section('title',$userExam->exam->title)
@section('content')

<section class="page-head align-items-center text-center d-flex">
    <div class="container">
        <h1>{{ $userExam->exam->title }}</h1>
    </div>
</section>
<div class="inner-page grey-bg">
    <div class="container">
        <div class="test-result bg-white">
            <div class="result-head d-flex align-items-center justify-content-between">
                <h4>{{ __('Level Test Result') }}</h4>
                <span class="result">{{ $userExam->result_percentage }}%</span>
            </div>
            <div class="d-flex align-items-end">
                <div class="result-summery">
                    <div class="result-row">
                        @if($userExam->exam->duration!==null)
                        <h6><i class="fas fa-clock"></i> {{ __('Test duration') }}</h6>
                        <span>{{ round($userExam->exam->duration/60,2) }} {{ __('Hours') }}</span>
                        @endif
                    </div>
                    <div class="result-row">
                        <h6><i class="fas fa-pencil-alt"></i> {{ __('Questions No.') }}</h6>
                        <span>{{ $userExam->questions_count }}</span>
                    </div>
                    <div class="result-row">
                        <h6><i class="fas fa-check"></i> {{ __('Correct answer') }}</h6>
                        <span>{{ $userExam->correct_answers_count }}</span>
                    </div>
                </div>
                @if(!$userExam->exam_is_running)
                <a class="btn btn main-custom-btn"
                    href="{{ route('frontend.exams.exam.retest',$userExam->exam->id) }}">{{ __('Re test') }}</a>
                @endif
            </div>
        </div>
        <div class="recommendation">
            @if($recommendedCourses==[])
            <h2 class="inner-title">{{ __('Recommended Courses for You') }}</h2>
            <div class="courses-recommended owl-carousel">
                @foreach($recommendedCourses as $key => $course)
                @includeIf('course::frontend.courses.index-partials.course-block',['wrapperClass'=>''])
                @endforeach
            </div>
            @endif
        </div>
    </div>
</div>



@endsection
