@extends('apps::dashboard.layouts.app')
@section('title', "update")
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
                    <a href="{{ url(route('dashboard.mobile-versions.index')) }}">
                        {{__('Mobile Versions')}}
                    </a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="#">update</a>
                </li>
            </ul>
        </div>

        <h1 class="page-title"></h1>

        <div class="row">
            {!! Form::model($model,[
                         'url'=> route('dashboard.mobile-versions.update',$model->id),
                         'id'=>'updateForm',
                         'role'=>'form',
                         'page'=>'form',
                         'class'=>'form-horizontal form-row-seperated',
                         'method'=>'PUT',
                         'files' => true
                         ])!!}

                <div class="col-md-12">


                    {{-- PAGE CONTENT --}}
                    <div class="col-md-12">
                        <div class="tab-content">

                            {{-- UPDATE FORM --}}
                            <div class="tab-pane active fade in" id="general">
                                <div class="col-md-10">

                                    @include('apps::dashboard.mobile-versions.form')

                                </div>
                            </div>


                            {{-- PAGE ACTION --}}
                            <div class="col-md-12">
                                <div class="form-actions">
                                    @include('apps::dashboard.layouts._ajax-msg')
                                    <div class="form-group">
                                        <button type="submit" id="submit" class="btn btn-lg green">
                                            {{__('apps::dashboard.buttons.edit')}}
                                        </button>
                                        <a href="{{url(route('dashboard.mobile-versions.index')) }}" class="btn btn-lg red">
                                            {{__('apps::dashboard.buttons.back')}}
                                        </a>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            {!! Form::close()!!}
        </div>
    </div>
</div>
@stop
