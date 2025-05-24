@extends('apps::frontend.layouts.app')
@section('title', __('authentication::frontend.register.index.title'))
@section('content')
    <section class="inner-banner">
        <div class="container">
            <ul class="list-unstyled thm-breadcrumb">
                <li><a href="{{ route('frontend.home') }}">{{ __('Home') }} </a></li>
                <li class="active"><a href="#">@lang('New student')</a></li>
            </ul>
        </div>
    </section>

    <section class="contact-one bg-color-dark">
        <div class="container justify-content-center">

            <h2 class="contact-one__title text-center">@lang('New student')</h2>
            {!! Form::open([
                'url' => route('frontend.auth.register.post'),
                'method' => 'POST',
                'class' => 'login-form contact-one__form',
                'files' => true,
                'novalidate' => '',
            ]) !!}

            @include('apps::frontend.layouts._alerts')

            <input type="hidden" name="from" value="{{ request()->from ?? '' }}" />
            
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="row low-gutters ">
                        {!! field('auth')->text('name', __('Name')) !!}
                        {{-- 
                    @inject('academic_years','Modules\Catalog\Entities\AcademicYear')
                    {!! field('auth')->select('academic_year_id',__('School Year'),$academic_years->active()->pluck('title','id')->toArray())!!} --}}

                        {!! field('auth')->email('mobile', __('Mobile')) !!}
                        {!! field('auth')->email('email', __('Email')) !!}
                        {!! field('auth')->password('password', __('Password')) !!}
                        {!! field('auth')->password('password_confirmation', __('Confirm Password')) !!}

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember">@lang('Remember')
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="text-center">
                                <button type="submit" class="contact-one__btn thm-btn">@lang('Sign Up')</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}

            <div class="log-link">
                <a href="{{ route('frontend.auth.login') }}" class="btn btn-link">
                    @lang('Login')
                </a>
                <a href="{{ route('frontend.auth.password.request') }}" class="btn btn-link">
                    @lang('Forgot your password?')
                </a>
            </div>

        </div>
    </section>

@stop
