@extends('apps::dashboard.layouts.app')
@section('title', __('apps::dashboard.index.title'))
@section('content')

    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <a href="{{ url(route('dashboard.home')) }}">
                            {{ __('apps::dashboard.index.title') }}
                        </a>
                    </li>
                </ul>
            </div>
            <h1 class="page-title"> {{ __('apps::dashboard.index.welcome') }} ,
                <small><b style="color:red">{{ Auth::user()->name }} </b></small>
            </h1>

            @can('show_statistics')

{{--                --}}{{-- DATATABLE FILTER --}}
{{--                <div class="portlet light bordered">--}}
{{--                    <div class="portlet-title tabbable-line">--}}
{{--                        <div class="caption">--}}
{{--                            <i class="icon-bubbles font-dark hide"></i>--}}
{{--                            <span class="caption-subject font-dark bold uppercase">--}}
{{--                                {{__('apps::dashboard.datatable.form.date_range')}}--}}
{{--                            </span>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="portlet-body">--}}
{{--                        <div id="filter_data_table">--}}
{{--                            <div class="panel-body">--}}
{{--                                <form class="horizontal-form">--}}
{{--                                    <div class="form-body">--}}
{{--                                        <div class="row">--}}
{{--                                            <div class="col-md-9">--}}
{{--                                                <div class="form-group">--}}
{{--                                                    <div id="reportrange" class="btn default form-control">--}}
{{--                                                        <i class="fa fa-calendar"></i> &nbsp;--}}
{{--                                                        <span> </span>--}}
{{--                                                        <b class="fa fa-angle-down"></b>--}}
{{--                                                        <input type="hidden" name="from">--}}
{{--                                                        <input type="hidden" name="to">--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                            <div class="form-actions col-md-3">--}}

{{--                                                <button class="btn btn-sm green btn-outline filter-submit margin-bottom"--}}
{{--                                                        type="submit">--}}
{{--                                                    <i class="fa fa-search"></i>--}}
{{--                                                    {{__('apps::dashboard.datatable.search')}}--}}
{{--                                                </button>--}}
{{--                                                <a class="btn btn-sm red btn-outline filter-cancel"--}}
{{--                                                   href="{{url(route('dashboard.home'))}}">--}}
{{--                                                    <i class="fa fa-times"></i>--}}
{{--                                                    {{__('apps::dashboard.datatable.reset')}}--}}
{{--                                                </a>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </form>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                --}}{{-- END DATATABLE FILTER --}}

{{--                <div class="row">--}}
{{--                    <div class="portlet light bordered col-lg-12">--}}
{{--                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">--}}
{{--                            <a class="dashboard-stat dashboard-stat-v2 blue"--}}
{{--                               href="{{url(route('dashboard.families.index'))}}">--}}

{{--                                <div class="visual">--}}
{{--                                    <i class="fa fa-child"></i>--}}
{{--                                </div>--}}
{{--                                <div class="details">--}}
{{--                                    <div class="number">--}}
{{--                                        <span data-counter="counterup" data-value="{{$countFamilies}}">0</span>--}}
{{--                                    </div>--}}
{{--                                    <div class="desc">{{ __('apps::dashboard.index.statistics.families') }}</div>--}}
{{--                                </div>--}}
{{--                            </a>--}}
{{--                        </div>--}}
{{--                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">--}}
{{--                            <a class="dashboard-stat dashboard-stat-v2 red"--}}
{{--                               href="{{url(route('dashboard.charities.index'))}}">--}}

{{--                                <div class="visual">--}}
{{--                                    <i class="fa fa-building-o"></i>--}}
{{--                                </div>--}}
{{--                                <div class="details">--}}
{{--                                    <div class="number">--}}
{{--                                        <span data-counter="counterup" data-value="{{$countCharities}}">0</span>--}}
{{--                                    </div>--}}
{{--                                    <div class="desc">{{ __('apps::dashboard.index.statistics.charities') }}</div>--}}
{{--                                </div>--}}
{{--                            </a>--}}
{{--                        </div>--}}
{{--                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">--}}
{{--                            <a class="dashboard-stat dashboard-stat-v2 orange"--}}
{{--                               href="{{url(route('dashboard.volunteers.index'))}}">--}}

{{--                                <div class="visual">--}}
{{--                                    <i class="fa fa-users"></i>--}}
{{--                                </div>--}}
{{--                                <div class="details">--}}
{{--                                    <div class="number">--}}
{{--                                        <span data-counter="counterup" data-value="{{$countVolunteers}}">0</span>--}}
{{--                                    </div>--}}
{{--                                    <div class="desc">{{ __('apps::dashboard.index.statistics.volunteers') }}</div>--}}
{{--                                </div>--}}
{{--                            </a>--}}
{{--                        </div>--}}
{{--                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">--}}
{{--                            <a class="dashboard-stat dashboard-stat-v2 green"--}}
{{--                               href="{{url(route('dashboard.donors.index'))}}">--}}

{{--                                <div class="visual">--}}
{{--                                    <i class="fa fa-users"></i>--}}
{{--                                </div>--}}
{{--                                <div class="details">--}}
{{--                                    <div class="number">--}}
{{--                                        <span data-counter="counterup" data-value="{{$countDonors}}">0</span>--}}
{{--                                    </div>--}}
{{--                                    <div class="desc">{{ __('apps::dashboard.index.statistics.donors') }}</div>--}}
{{--                                </div>--}}
{{--                            </a>--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                    <div class="portlet light bordered col-lg-12">--}}
{{--                        <div class="portlet-title tabbable-line">--}}
{{--                            <div class="caption">--}}
{{--                                <i class="icon-bubbles font-dark hide"></i>--}}
{{--                                <span class="caption-subject font-dark bold uppercase">--}}
{{--                                {{__('apps::dashboard.index.statistics.titles.orders')}}--}}
{{--                            </span>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="col-lg-4">--}}
{{--                            <a class="dashboard-stat dashboard-stat-v2 label-warning"--}}
{{--                               href="{{url(route('dashboard.orders.index'))}}" style="color: white">--}}

{{--                                <div class="visual">--}}
{{--                                    <i class="fa fa-shopping-cart"></i>--}}
{{--                                </div>--}}
{{--                                <div class="details">--}}
{{--                                    <div class="number">--}}
{{--                                        <span data-counter="counterup" data-value="{{$countPendingOrders}}">0</span>--}}
{{--                                    </div>--}}
{{--                                    <div class="desc">{{ __('apps::dashboard.index.statistics.pending_orders') }}</div>--}}
{{--                                </div>--}}
{{--                            </a>--}}
{{--                        </div>--}}

{{--                        <div class="col-lg-4">--}}
{{--                            <a class="dashboard-stat dashboard-stat-v2 green-dark"--}}
{{--                               href="{{url(route('dashboard.orders.index'))}}" style="color: white">--}}

{{--                                <div class="visual">--}}
{{--                                    <i class="fa fa-shopping-cart"></i>--}}
{{--                                </div>--}}
{{--                                <div class="details">--}}
{{--                                    <div class="number">--}}
{{--                                        <span data-counter="counterup" data-value="{{$countDeliveredOrders}}">0</span>--}}
{{--                                    </div>--}}
{{--                                    <div class="desc">{{ __('apps::dashboard.index.statistics.delivered_orders') }}</div>--}}
{{--                                </div>--}}
{{--                            </a>--}}
{{--                        </div>--}}
{{--                        <div class="col-lg-4">--}}
{{--                            <a class="dashboard-stat dashboard-stat-v2 label-primary"--}}
{{--                               href="{{url(route('dashboard.orders.index'))}}" style="color: white">--}}

{{--                                <div class="visual">--}}
{{--                                    <i class="fa fa-shopping-cart"></i>--}}
{{--                                </div>--}}
{{--                                <div class="details">--}}
{{--                                    <div class="number">--}}
{{--                                        <span data-counter="counterup" data-value="{{$countTotalOrders}}">0</span>--}}
{{--                                    </div>--}}
{{--                                    <div class="desc">{{ __('apps::dashboard.index.statistics.total_orders') }}</div>--}}
{{--                                </div>--}}
{{--                            </a>--}}
{{--                        </div>--}}

{{--                    </div>--}}

{{--                    <div class="portlet light bordered col-lg-12">--}}
{{--                        <div class="portlet-title tabbable-line">--}}
{{--                            <div class="caption">--}}
{{--                                <i class="icon-bubbles font-dark hide"></i>--}}
{{--                                <span class="caption-subject font-dark bold uppercase">--}}
{{--                                {{__('apps::dashboard.index.statistics.titles.donations')}}--}}
{{--                            </span>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="col-lg-12">--}}
{{--                            <a class="dashboard-stat dashboard-stat-v2 blue" href="{{url(route('dashboard.donate_resources.index'))}}">--}}
{{--                                <div class="visual">--}}
{{--                                    <i class="fa fa-bar-chart-o"></i>--}}
{{--                                </div>--}}
{{--                                <div class="details">--}}
{{--                                    <div class="number">--}}
{{--                                        <span data-counter="counterup" data-value="{{$donate_resources}}">0</span>--}}
{{--                                    </div>--}}
{{--                                    <div class="desc">{{ __('apps::dashboard.index.statistics.donate_resources') }}</div>--}}
{{--                                </div>--}}
{{--                            </a>--}}
{{--                            <br>--}}
{{--                        </div>--}}
{{--                        <div class="col-lg-4">--}}
{{--                            <a class="dashboard-stat dashboard-stat-v2 green" href="{{url(route('dashboard.donations.index'))}}">--}}
{{--                                <div class="visual">--}}
{{--                                    <i class="fa fa-bar-chart-o"></i>--}}
{{--                                </div>--}}
{{--                                <div class="details">--}}
{{--                                    <div class="number">--}}
{{--                                        <span data-counter="counterup" data-value="{{$projectTotalProfit}}">0</span> KWD--}}
{{--                                    </div>--}}
{{--                                    <div class="desc">{{ __('apps::dashboard.index.statistics.total_projects_profits') }}</div>--}}
{{--                                </div>--}}
{{--                            </a>--}}
{{--                        </div>--}}
{{--                        <div class="col-lg-4">--}}
{{--                            <a class="dashboard-stat dashboard-stat-v2 green" href="{{url(route('dashboard.donations.index'))}}">--}}
{{--                                <div class="visual">--}}
{{--                                    <i class="fa fa-bar-chart-o"></i>--}}
{{--                                </div>--}}
{{--                                <div class="details">--}}
{{--                                    <div class="number">--}}
{{--                                        <span data-counter="counterup" data-value="{{$basketTotalProfit}}">0</span> KWD--}}
{{--                                    </div>--}}
{{--                                    <div class="desc">{{ __('apps::dashboard.index.statistics.total_baskets_profits') }}</div>--}}
{{--                                </div>--}}
{{--                            </a>--}}
{{--                        </div>--}}
{{--                        <div class="col-lg-4">--}}
{{--                            <a class="dashboard-stat dashboard-stat-v2 green" href="{{url(route('dashboard.donations.index'))}}">--}}
{{--                                <div class="visual">--}}
{{--                                    <i class="fa fa-bar-chart-o"></i>--}}
{{--                                </div>--}}
{{--                                <div class="details">--}}
{{--                                    <div class="number">--}}
{{--                                        <span data-counter="counterup" data-value="{{$totalProfit}}">0</span> KWD--}}
{{--                                    </div>--}}
{{--                                    <div class="desc">{{ __('apps::dashboard.index.statistics.total_profits') }}</div>--}}
{{--                                </div>--}}
{{--                            </a>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}

            @endcan
        </div>
    </div>

@stop
