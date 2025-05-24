@extends('apps::frontend.layouts.app')
@section('title', __('authentication::frontend.change_password.index.title') )
@section('content')
<section class="inner-banner">
    <div class="container">
        <ul class="list-unstyled thm-breadcrumb">
        <li><a href="{{ route('frontend.home') }}">{{ __('Home') }} </a></li>
        <li class="active"><a href="#">@lang("authentication::frontend.login.index.title")</a></li>
        </ul>
    </div>
</section>
  
  
<section class="contact-one bg-color-dark">
    <div class="container justify-content-center">

        <h2 class="contact-one__title text-center">@lang('authentication::frontend.login.index.title')</h2>
        {!! Form::open([
            'url'=> route('frontend.password.update'),
            'method'=>'POST',
            'class'=>'login-form contact-one__form',
            'files' => true,
            'novalidate' => ''
            ])!!}

            @include('apps::frontend.layouts._alerts')

            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="row low-gutters ">
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">
                    {!! field('auth')->email('email',__('Email'),$request->email,['readonly' => ''])!!}
                    {!! field('auth')->password('password',__('Password'))!!}
                    {!! field('auth')->password('password_confirmation',__('Confirm Password'))!!}
                    <div class="col-lg-12">
                        <div class="text-center">
                            <button type="submit" class="contact-one__btn thm-btn">{{ __('authentication::frontend.change_password.index.title') }}</button>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        {!! Form::close() !!}

    </div>
</section>
@endsection
