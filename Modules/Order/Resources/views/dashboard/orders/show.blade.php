@extends('apps::dashboard.layouts.app')
@section('title', __('order::dashboard.orders.show.title'))
@section('content')

<style type="text/css" media="print">
	@page {
		size  : auto;
		margin: 0;
	}
	@media print {
		a[href]:after {
		content: none !important;
	}
	.contentPrint{
			width: 100%;
		}
		.no-print, .no-print *{
			display: none !important;
		}
	}
</style>

<div class="page-content-wrapper">
    <div class="page-content">
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <a href="{{ url(route('dashboard.home')) }}">{{ __('apps::dashboard.index.title') }}</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="{{ url(route('dashboard.orders.index')) }}">
                        {{__('order::dashboard.orders.index.title')}}
                    </a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="#">{{__('order::dashboard.orders.show.title')}}</a>
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
                                <a data-toggle="tab" href="#order">
                                    <i class="fa fa-cog"></i> {{__('order::dashboard.orders.show.invoice')}}
                                </a>
                                <span class="after"></span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-9 contentPrint">
                    <div class="tab-content">

                        <div class="tab-pane active" id="order">
                            <div class="invoice-content-2 bordered">

                                <div class="col-md-12" style="margin-bottom: 24px;">
                                    <center>
                                        <img src="{{ asset(setting('footer_logo')) }}" class="img-responsive" style="width:18%" />
                                        <b>
                                            #{{ $order['id'] }} -
                                            {{ date('Y-m-d / H:i:s' , strtotime($order->created_at)) }} / {{ $order['type'] }}
                                        </b>
                                    </center>
									@if ($order['type'] == 'cash')
										<center>{{__('order::dashboard.orders.show.cash_payment')}}</center>
									@else
										<center>{{ $order->orderStatus->title }}</center>
									@endif
                                </div>

                                @if ($order->user)
                                    <div class="row">
                                        <div class="col-xs-12 table-responsive">
                                            <table class="table table-striped table-hover">
                                                <thead>
                                                    <tr>
                                                        <th class="invoice-title uppercase text-center">
                                                            {{__('order::dashboard.orders.show.username')}}
                                                        </th>
                                                        <th class="invoice-title uppercase text-center">
                                                            {{__('order::dashboard.orders.show.email')}}
                                                        </th>
                                                        <th class="invoice-title uppercase text-center">
                                                            {{__('order::dashboard.orders.show.mobile')}}
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="text-center sbold"> {{ $order->user->name }}</td>
                                                        <td class="text-center sbold"> {{ $order->user->email }}</td>
                                                        <td class="text-center sbold"> {{ $order->user->mobile }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                @endif

                                <div class="row">
                                    <div class="col-xs-12 table-responsive">
                                        <table class="table table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th class="invoice-title uppercase text-center">
                                                        #
                                                    </th>
                                                    <th class="invoice-title uppercase text-center">
                                                        {{__('Image')}}
                                                    </th>
                                                    <th class="invoice-title uppercase text-center">
                                                        {{__('order::dashboard.orders.show.order.course_title')}}
                                                    </th>
                                                    <th class="invoice-title uppercase text-center">
                                                        {{__('Trainer')}}
                                                    </th>
                                                    <th class="invoice-title uppercase text-center">
                                                        {{__('order::dashboard.orders.show.order.course_price')}}
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($order->orderCourses as $course)
                                                    <tr>
                                                        <td class="text-center sbold">
                                                            {{$course->course?->id}}
                                                        </td>
                                                        <td class="text-center sbold">
                                                            <img src="{{ asset($course->course?->image) }}" alt="" style="max-width:10%">
                                                        </td>
                                                        <td class="text-center sbold">
                                                            {{$course->course?->title}}
                                                        </td>

                                                        <td class="text-center sbold">
                                                            {{ $course->course?->trainer?->name }}
                                                        </td>
                                                        <td class="text-center sbold">
                                                            {{ $course->total }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            

                                <div class="row">
                                    <div class="col-xs-12 table-responsive">
                                        <table class="table table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th class="invoice-title uppercase text-center">
                                                        {{__('order::dashboard.orders.show.order.subtotal')}}
                                                    </th>
                                                    <th class="invoice-title uppercase text-center">
                                                        {{__('order::dashboard.orders.show.order.off')}}
                                                    </th>
                                                    <th class="invoice-title uppercase text-center">
                                                        {{__('order::dashboard.orders.show.order.total')}}
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="text-center sbold">
                                                        {{ $order->subtotal }} {{ setting('default_currency') }}
                                                    </td>
                                                    <td class="text-center sbold">
                                                        {{ $order->discount }} {{ setting('default_currency') }}
                                                    </td>
                                                    <td class="text-center sbold">
                                                        {{ $order->total }} {{ setting('default_currency') }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-4">
                    <a class="btn btn-lg blue hidden-print margin-bottom-5" onclick="javascript:window.print();">
                        {{__('apps::dashboard.buttons.print')}}
                        <i class="fa fa-print"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@stop

@section('scripts')

<script>
    $('.24_format').timepicker({
        showMeridian: true,
        format: 'hh:mm',
    });

    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
        startDate: '0d'
    });
</script>

@stop
