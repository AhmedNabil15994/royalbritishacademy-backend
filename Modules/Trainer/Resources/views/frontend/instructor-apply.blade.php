@extends('apps::frontend.layouts.app')
@section('title', __('Become Instructor'))
@section('content')
<section class="page-head align-items-center text-center d-flex">
    <div class="container">
        <h1>{{ __('Become Instructor') }}</h1>
    </div>
</section>
<div class="inner-page grey-bg">
    <div class="container">
        <div class="custom-form w50">
            <h2 class="form-title text-center">{{ __('Please fill the following fields') }}</h2>
            <div id="result"></div>
            {!! Form::open([
            'url'=> route('frontend.trainers.apply'),
            'method'=>'POST',
            'id'=>'form',
            'role'=>'form',
            'class'=>'login-form active',
            'files' => true
            ])!!}
            <div>
                {!! field('frontend')->text('name',__('Your full Name *'))!!}
            </div>
            <div class="my-4">
                {!! field('frontend')->text('mobile',__('Your Mobile No. *'))!!}
            </div>
            <div>
                {!! field('frontend')->email('email',__('Your Email *') )!!}
            </div>
            <div>
                {!! field('frontend')->select('country_id',__('Country'),$countries,old('country_id'),
                ["data-select2-id"=>"1", "tabindex"=>"-1", "aria-hidden"=>"true"]) !!}
            </div>

            <div class="custom-upload">
                <span>
                    <i class="fas fa-file"></i>
                    {!! __('Upload your Resume <br> with a recent clear face picture of you') !!}
                </span>

                {!! field('frontend')->file('cv',__('Your Cv *') )!!}

            </div>

            <div class="text-center">
                <button class="btn btn main-custom-btn"
                    type="submit"> {{ __('Send Request') }}</button>

            </div>

            {!! Form::close() !!}
        </div>
    </div>
</div>

@endsection


@push('styles')
<style>
    .hide {
        display: none
    }

</style>
@endpush
