@extends('apps::frontend.layouts.app')
@section('title', __('authentication::frontend.login.index.title') )
@section('content')
<section class="inner-banner">
  <div class="container">
    <ul class="list-unstyled thm-breadcrumb">
      <li><a href="{{ route('frontend.home') }}">{{ __('Home') }} </a></li>
      <li class="active"><a href="#">@lang("authentication::frontend.reset_password.index.title")</a></li>
    </ul>
  </div>
</section>


<section class="contact-one bg-color-dark">
    <div class="container justify-content-center">

        <h2 class="contact-one__title text-center">@lang('authentication::frontend.reset_password.index.title')</h2>
        {!! Form::open([
            'url'=> route('frontend.auth.password.email'),
            'method'=>'POST',
            'class'=>'login-form contact-one__form',
            'files' => true,
            'novalidate' => ''
            ])!!}

            @include('apps::frontend.layouts._alerts')

            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="row low-gutters ">
                        {!! field('auth')->email('email',__('Email'))!!}
                        <div class="col-lg-12">
                            <div class="text-center">
                                <button type="submit" class="contact-one__btn thm-btn">{{ __('authentication::frontend.reset_password.index.title') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        {!! Form::close() !!}

    </div>
</section>
@stop
