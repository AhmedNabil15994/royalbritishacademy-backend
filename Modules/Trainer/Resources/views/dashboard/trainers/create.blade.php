@extends('apps::dashboard.layouts.app')
@section('title', __('trainer::dashboard.trainers.create.title'))
@section('content')
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <a href="{{ url(route('dashboard.home')) }}">{{ __('apps::dashboard.index.title') }}</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="{{ url(route('dashboard.trainers.index')) }}">
                        {{__('trainer::dashboard.trainers.index.title')}}
                    </a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="#">{{__('trainer::dashboard.trainers.create.title')}}</a>
                </li>
            </ul>
        </div>

        <h1 class="page-title"></h1>

        <div class="row">
            {!! Form::open([
            'url'=> route('dashboard.trainers.store'),
            'id'=>"form",
            'role'=>"form",
            'method'=>'POST',
            'class'=>'form-horizontal form-row-seperated',
            'files' => true
            ])
            !!}




            <div class="col-md-12">

                {{-- RIGHT SIDE --}}
                <div class="col-md-3">
                    <div class="panel-group accordion scrollable"
                        id="accordion2">
                        <div class="panel panel-default">

                            <div id="collapse_2_1"
                                class="panel-collapse in">
                                <div class="panel-body">
                                    <ul class="nav nav-pills nav-stacked">
                                        <li class="active">
                                            <a href="#global_setting"
                                                data-toggle="tab">
                                                {{ __('trainer::dashboard.trainers.create.form.general') }}
                                            </a>
                                        </li>
                                        <li class="">
                                            <a href="#profile"
                                                data-toggle="tab">
                                                {{ __('trainer::dashboard.trainers.create.form.profile') }}
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- PAGE CONTENT --}}
                <div class="col-md-9">
                    <div class="tab-content">

                        {{-- CREATE FORM --}}
                        <div class="tab-pane active fade in"
                            id="global_setting">

                            <div class="col-md-10">
                                @include('trainer::dashboard.trainers.form.form')
                            </div>
                        </div>

                        <div class="tab-pane fade in"
                            id="profile">
                            <h3 class="page-title">{{__('trainer::dashboard.trainers.create.form.profile')}}</h3>
                            <div class="col-md-10">
                                @include('trainer::dashboard.trainers.form.profile')
                            </div>
                        </div>
                        {{-- END CREATE FORM --}}

                    </div>
                </div>

                {{-- PAGE ACTION --}}
                <div class="col-md-12">
                    <div class="form-actions">
                        @include('apps::dashboard.layouts._ajax-msg')
                        <div class="form-group">
                            <button type="submit"
                                id="submit"
                                class="btn btn-lg blue">
                                {{__('apps::dashboard.buttons.add')}}
                            </button>
                            <a href="{{url(route('dashboard.trainers.index')) }}"
                                class="btn btn-lg red">
                                {{__('apps::dashboard.buttons.back')}}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@stop
