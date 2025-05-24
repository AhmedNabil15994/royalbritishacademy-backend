@extends('apps::frontend.layouts.app')
@section('title',__('English Level Test'))
@section('content')
<div class="inner-page grey-bg">
    <div class="container">
        @include('apps::frontend.layouts.components._msg')
        <div class="test-head">
            <div class="d-flex justify-content-between">
                <h1>{{ $exam->title }}</h1>
                @if($exam->duration!=null)
                <span class="test-time">{{ __('Test Ends after') }} <span id="Timerapp"></span></span>
                @endif
            </div>
            <p>{{ __('For the questions below, please choose the best option to complete the sentence or conversation.')
                }}</p>

        </div>
        {!! Form::open([
        'url'=> route('frontend.exams.level.test',$exam->id),
        'method'=>'POST',
        // 'id'=>'form',
        // 'role'=>'form',
        'class'=>'login-form active',
        'files' => true
        ])!!}

        <div class="exame-questions">
            @foreach($exam->questions as $key => $question)
            <input type="hidden"
                name="answers[{{ $question->id }}][question]"
                value="{{ $question->id }}">
            <div class="question-block">
                <h3 class="question-head">{{ $loop->iteration }}- {{ $question->question }}
                    @if($question->type=='audio')
                    <br />
                    <audio controls
                        autoplay>
                        <source src="{{ $question->getFirstMediaUrl('audio') }}"
                            type="audio/ogg">
                    </audio>
                    @endif
                </h3>
                <div class="choose-answer">
                    @foreach($question->answers as $key => $answer)
                    <div class="answer-block">
                        <div class="custom-control custom-radio flex-1">
                            <input type="radio"
                                id="question[{{ $answer->id }}]"
                                name="answers[{{ $question->id }}][answer]"
                                class=""
                                value="{{ $answer->id }}">
                            <label class=""
                                for="question[{{ $answer->id }}]"> {{ $answer->answer }}</label>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
            <div class="text-center">
                <button class="btn btn main-custom-btn"
                    type="submit"> {{ __('Send') }}</button>

            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>

@endsection


@push('scripts')


<script>
    @if($exam->duration!=null)
    var countDownDate = "{{$userExam->exam_is_running }}";
    var x = setInterval(function() {
        // Get today's date and time
        var now = new Date().getTime();
        // Find the distance between now and the count down date
        var distance = countDownDate - now;
        // Time calculations for days, hours, minutes and seconds
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        // Output the result in an element with id="demo"
        document.getElementById("Timerapp").innerHTML = hours + "h " +
            minutes + "m " + seconds + "s ";

        // If the count down is over, write some text
        if (distance < 0) {
            clearInterval(x);
            document.getElementById("Timerapp").innerHTML = "{{ __("Exam Time finished") }}";
        }
    }, 1000);
@endif
</script>

@endpush
