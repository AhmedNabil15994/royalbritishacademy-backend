@extends('apps::dashboard.layouts.app')
@section('title', __('trainer::dashboard.applies.routes.show'))
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
                    <a href="{{ url(route('dashboard.applies.index')) }}">
                        {{__('trainer::dashboard.applies.routes.index')}}
                    </a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="#">{{__('trainer::dashboard.applies.routes.show')}}</a>
                </li>
            </ul>
        </div>

        <h1 class="page-title"></h1>

        <div class="row">
            <div class="col-md-12">
                <div class="no-print">
                    <div class="col-md-3">
                        <ul class="ver-inline-menu tabbable margin-bottom-10">
                            <li class="active">
                                <a data-toggle="tab"
                                    href="#customer_order">
                                    <i class="fa fa-cog"></i> {{__('trainer::dashboard.applies.show.applier_data')}}
                                </a>
                                <span class="after"></span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-9 contentPrint">
                    <div class="tab-content">

                        <div class="tab-pane active"
                            id="customer_order">

                            <div class="invoice-content-2 bordered">
                                <div class="row invoice-head">
                                    <div class="row invoice-subtotal">
                                        <div class="col-xs-2">
                                            <h4 class="text-center notbold">
                                                {{__('trainer::dashboard.applies.show.name')}}
                                            </h4>
                                            <p class="text-center notbold">{{ $model->name }}</p>
                                        </div>
                                        <div class="col-xs-2">
                                            <h4 class="text-center notbold">
                                                {{__('trainer::dashboard.applies.show.email')}}</h4>
                                            <p class="text-center notbold">{{ $model->email }}</p>
                                        </div>
                                        <div class="col-xs-2">
                                            <h4 class="text-center notbold">
                                                {{__('trainer::dashboard.applies.show.mobile')}}</h4>
                                            <p class="text-center notbold">{{ $model->mobile }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@stop
