@extends('apps::frontend.layouts.app')
@section('title', __('authentication::frontend.login.index.title') )
@section('content')
<section class="inner-banner">
  <div class="container">
    <ul class="list-unstyled thm-breadcrumb">
      <li><a href="{{ route('frontend.home') }}">{{ __('Home') }} </a></li>
      <li class="active"><a href="#">@lang("Get OTP")</a></li>
    </ul>
  </div>
</section>

<section class="contact-one bg-color-dark">
    <div class="container justify-content-center">

        <h2 class="contact-one__title text-center">@lang("Get OTP")</h2>
        {!! Form::open([
            'url'=> route('frontend.auth.login.post'),
            'method'=>'POST',
            'class'=>'login-form contact-one__form',
            'files' => true,
            'novalidate' => ''
            ])!!}

            @include('apps::frontend.layouts._alerts')

            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="row low-gutters ">
                        {!! field('auth')->number('mobile',__('Phone'))!!}
                        <div class="col-lg-12">
                            <div class="text-center">
                                <button type="submit" class="contact-one__btn thm-btn">@lang("Continue")</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}

    </div>
</section>

@stop
