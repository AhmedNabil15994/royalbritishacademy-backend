@extends('apps::dashboard.layouts.app')
@section('title', __('order::dashboard.orders-reports.index.title'))
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
                    <a href="#">{{__('order::dashboard.orders-reports.index.title')}}</a>
                </li>
            </ul>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="portlet light bordered">

                    {{-- DATATABLE FILTER --}}
                    <div class="row">
                        <div class="portlet box grey-cascade">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="fa fa-gift"></i>
                                    {{__('apps::dashboard.datatable.search')}}
                                </div>
                                <div class="tools">
                                    <a href="javascript:;"
                                        class="collapse"
                                        data-original-title=""
                                        title=""> </a>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div id="filter_data_table">
                                    <div class="panel-body">
                                        <form id="formFilter"
                                            class="horizontal-form">
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="control-label">
                                                                {{__('apps::dashboard.datatable.form.date_range')}}
                                                            </label>
                                                            <div id="reportrange"
                                                                class="btn default form-control">
                                                                <i class="fa fa-calendar"></i> &nbsp;
                                                                <span> </span>
                                                                <b class="fa fa-angle-down"></b>
                                                                <input type="hidden"
                                                                    name="from">
                                                                <input type="hidden"
                                                                    name="to">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="control-label">
                                                                {{__('Order Status')}}
                                                            </label>
                                                            <select name="order_status_id"
                                                                id="single"
                                                                class="form-control select2">
                                                                <option value="">
                                                                    {{__('apps::dashboard.datatable.form.select')}}
                                                                </option>
                                                                @inject('orderStatus','Modules\Order\Entities\OrderStatus')
                                                                @foreach ($orderStatus->get() as $status)
                                                                <option value="{{ $status['id'] }}"
                                                                    @if(request('order_status_id')==$status['id'])
                                                                    selected
                                                                    @endif>
                                                                    {{ $status->title }}
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="control-label">
                                                                {{__('order::dashboard.orders.datatable.courses')}}
                                                            </label>
                                                            <select name="course_id"
                                                                id="single"
                                                                class="form-control select2">
                                                                <option value="">
                                                                    {{__('apps::dashboard.datatable.form.select')}}
                                                                </option>
                                                                @if(! auth()->user()->can('trainer_access') && auth()->user()->can('dashboard_access'))
                                                                    @inject('courses', 'Modules\Course\Entities\Course')
                                                                @else
                                                                    @php $courses = Modules\Course\Entities\Course::DashboardTrainer(); @endphp
                                                                @endif
                                                                @foreach ($courses->get() as $course)
                                                                <option value="{{ $course['id'] }}"
                                                                    @if(request('course_id')==$course['id'])
                                                                    selected
                                                                    @endif>
                                                                    {{ $course->title }}
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    @if(! auth()->user()->can('trainer_access') && auth()->user()->can('dashboard_access'))
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label class="control-label">
                                                                    {{__('order::dashboard.orders-reports.datatable.trainer')}}
                                                                </label>
                                                                <select name="trainer_id"
                                                                    id="single"
                                                                    class="form-control select2">
                                                                    <option value="">
                                                                        {{__('apps::dashboard.datatable.form.select')}}
                                                                    </option>
                                                                    @inject('trainers','Modules\Trainer\Repositories\Dashboard\TrainerRepository')
                                                                    @foreach ($trainers->getAll() as $trainer)
                                                                    <option value="{{ $trainer['id'] }}"
                                                                        @if(request('trainer')==$trainer['id'])
                                                                        selected
                                                                        @endif>
                                                                        {{ $trainer->name }}
                                                                    </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </form>
                                        <div class="form-actions">
                                            <button class="btn btn-sm green btn-outline filter-submit margin-bottom"
                                                id="search">
                                                <i class="fa fa-search"></i>
                                                {{__('apps::dashboard.datatable.search')}}
                                            </button>
                                            <button class="btn btn-sm red btn-outline filter-cancel">
                                                <i class="fa fa-times"></i>
                                                {{__('apps::dashboard.datatable.reset')}}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- END DATATABLE FILTER --}}

                    <div class="portlet-title">
                        <div class="caption font-dark">
                            <i class="icon-settings font-dark"></i>
                            <span class="caption-subject bold uppercase">
                                {{__('order::dashboard.orders-reports.index.title')}}
                            </span>
                        </div>
                    </div>

                    {{-- DATATABLE CONTENT --}}
                    <div class="portlet-body">
                        <table class="table table-striped table-bordered table-hover"
                            id="dataTable">
                            <thead>
                                <tr>
                                    <th>{{__('order::dashboard.orders-reports.datatable.order_id')}}</th>
                                    <th>{{__('order::dashboard.orders-reports.datatable.title')}}</th>
                                    <th>{{__('order::dashboard.orders-reports.datatable.trainer')}}</th>
                                    <th>{{__('order::dashboard.orders-reports.datatable.student_name')}}</th>
                                    <th>{{__('order::dashboard.orders-reports.datatable.student_mobile')}}</th>
                                    <th>{{__('order::dashboard.orders-reports.datatable.price')}} - {{
                                        setting('default_currency') }}</th>
                                    <th>{{__('order::dashboard.orders-reports.datatable.status')}}</th>
                                    <th>{{__('order::dashboard.orders-reports.datatable.created_at')}}</th>
                                </tr>
                            </thead>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('scripts')

<script>
    let buttonCommon = {
        exportOptions: {}
    };
    pdfMake.fonts = {
        Arial: {
                normal: 'arial.ttf',
                bold: 'arialbd.ttf',
                italics: 'ariali.ttf',
                bolditalics: 'arialbi.ttf'
        }
    };
    function tableGenerate(data = '') {

        var dataTable =
            $('#dataTable').DataTable({
                "pageLength": 50,
                "createdRow": function (row, data, dataIndex) {

                    if (data["id"] === '----') {
                        $(row).addClass('success');
                        $(row).addClass('without-hover');
                        $(row).hover(function () {
                            $(row).css("background-color", "transparent");
                        });
                    }
                },
                ajax: {
                    url: "{{ url(route('dashboard.orders.reports.datatable')) }}",
                    type: "GET",
                    data: {
                        req: data,
                    },
                },
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.10.16/i18n/{{ucfirst(LaravelLocalization::getCurrentLocaleName())}}.json"
                },
                stateSave: true,
                processing: true,
                serverSide: true,
                responsive: !0,
                order: [
                    [1, "desc"]
                ],
                columns: [
                    {
                        data: 'order_id',className: 'dt-center'
                    },
                    {
                        data: 'course_id',className: 'dt-center'
                    },
                    {
                        data: 'trainer',orderable: false,className: 'dt-center'
                    },
                    {
                        data: 'student_name',orderable: false,className: 'dt-center'
                    },
                    {
                        data: 'student_mobile',orderable: false,className: 'dt-center'
                    },
                    {
                        data: 'total',className: 'dt-center'
                    },
                    {
                        data: 'status',className: 'dt-center',orderable: false
                    },
                    {
                        data: 'created_at',className: 'dt-center'
                    },
                ],
                columnDefs: [
                ],
                dom: 'Bfrtip',
                lengthMenu: [
                    [10, 25, 50, 100, 500, 1000, 2000],
                    ['10', '25', '50', '1000', '2000']
                ],
                buttons: [

                    $.extend(true, {}, buttonCommon, {

                        text: "Page Length",
                        className: "btn blue btn-outline",
                        extend: 'pageLength'
                    }),

                    $.extend(true, {}, buttonCommon, {

                        text: "print",
                        className: "btn blue btn-outline",
                        extend: 'print',
                        exportOptions: {
                            columns: 'th:not(.hideInPrint)',
                        }
                    }),

                    $.extend(true, {}, buttonCommon, {
                        text: "excel",
                        className: "btn blue btn-outline",
                        extend: 'excelHtml5',
                        exportOptions: {
                            columns: 'th:not(.hideInPrint)',
                        }
                    }),
                    $.extend(true, {}, buttonCommon, {
                        text: "colvis",
                        className: "btn blue btn-outline",
                        extend: 'colvis'
                    }),
                ]
            });
    }

    jQuery(document).ready(function() {
        tableGenerate();
    });
</script>

@stop
