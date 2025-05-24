@extends('apps::dashboard.layouts.app')
@section('title', __('Mobile Versions'))
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
                    <a href="#">{{__('Mobile Versions')}}</a>
                </li>
            </ul>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="portlet light bordered">

                    <div class="table-toolbar">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="btn-group">
                                    <a href="{{ url(route('dashboard.mobile-versions.create')) }}" class="btn sbold green">
                                        <i class="fa fa-plus"></i> {{__('apps::dashboard.buttons.add_new')}}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="portlet-title">
                        <div class="caption font-dark">
                            <i class="icon-settings font-dark"></i>
                            <span class="caption-subject bold uppercase">
                                {{__('Mobile Versions')}}
                            </span>
                        </div>
                    </div>

                    {{-- DATATABLE CONTENT --}}
                    <div class="portlet-body">
                        <table class="table table-striped table-bordered table-hover" id="dataTable">
                            <thead>
                                <tr>
                                    <tr>
                                        <th class="hideInPrint">
                                            <a href="javascript:;" onclick="CheckAll()">
                                                {{__('apps::dashboard.buttons.select_all')}}
                                            </a>
                                        </th>
                                        <th>#</th>
                                        <th>system</th>
                                        <th>version</th>
                                        <th>production_status</th>
                                        <th>last_version</th>
                                        <th>force_update</th>
                                        <th >options</th>
                                    </tr>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <button type="submit" id="deleteChecked" class="btn red btn-sm" onclick="deleteAllChecked('{{ url(route('dashboard.mobile-versions.deletes')) }}')">
                                {{__('apps::dashboard.datatable.delete_all_btn')}}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('scripts')

  <script>
   function tableGenerate(data='') {

      var dataTable =
      $('#dataTable').DataTable({
          "createdRow": function( row, data, dataIndex ) {
             if ( data["deleted_at"] != null ) {
                $(row).addClass('danger');
             }
          },
          ajax : {
              url   : "{{ url(route('dashboard.mobile-versions.datatable')) }}",
              type  : "GET",
              data  : {
                  req : data,
              },
          },
          language: {
              url:"//cdn.datatables.net/plug-ins/1.10.16/i18n/{{ucfirst(LaravelLocalization::getCurrentLocaleName())}}.json"
          },
          stateSave: true,
          processing: true,
          serverSide: true,
          responsive: !0,
          order     : [[ 1 , "desc" ]],
          columns: [
                        {data: 'id', className: 'dt-center'},
                        {data: 'id', className: 'dt-center'},
                        {data: 'system', className: 'dt-center'},
                        {data: 'version', className: 'dt-center'},
                        {data: 'production_status', className: 'dt-center'},
                        {data: 'last_version', className: 'dt-center'},
                        {data: 'force_update', className: 'dt-center'},
                        {data: 'id'},
      		],
                    columnDefs: [
                        {
                            targets: 0,
                            width: '30px',
                            className: 'dt-center',
                            orderable: false,
                            render: function (data, type, full, meta) {
                                return `<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                          <input type="checkbox" value="` + data + `" class="group-checkable form-check-input" name="ids">
                          <span></span>
                        </label>
                      `;
                            },
                        },
                        {
                            targets: 4,
                            width: '30px',
                            className: 'dt-center',
                            render: function (data, type, full, meta) {
                                if (data == 1) {
                                    return '<span class="badge badge-success"> {{__('apps::dashboard.datatable.active')}} </span>';
                                } else {
                                    return '<span class="badge badge-danger"> {{__('apps::dashboard.datatable.unactive')}} </span>';
                                }
                            },
                        },
                        {
                            targets: 5,
                            width: '30px',
                            className: 'dt-center',
                            render: function (data, type, full, meta) {
                                if (data == 1) {
                                    return '<span class="badge badge-success"> {{__('apps::dashboard.datatable.active')}} </span>';
                                } else {
                                    return '<span class="badge badge-danger"> {{__('apps::dashboard.datatable.unactive')}} </span>';
                                }
                            },
                        },
                        {
                            targets: 6,
                            width: '30px',
                            className: 'dt-center',
                            render: function (data, type, full, meta) {
                                if (data == 1) {
                                    return '<span class="badge badge-success"> {{__('apps::dashboard.datatable.active')}} </span>';
                                } else {
                                    return '<span class="badge badge-danger"> {{__('apps::dashboard.datatable.unactive')}} </span>';
                                }
                            },
                        },
                        {
                            targets: -1,
                            width: '13%',
                            className: 'dt-center',
                            orderable: false,
                            render: function (data, type, full, meta) {

                                // Edit
                                var editUrl = '{{ route("dashboard.mobile-versions.edit", ":id") }}';
                                editUrl = editUrl.replace(':id', data);
                                return `
                                    <a href="` + editUrl + `" class="btn btn-success btn-xs" title="Edit">
                                      <i class="fa fa-edit"></i>
                                    </a>`;
                            },
                        },
                    ],
          dom: 'Bfrtip',
          lengthMenu: [
              [ 10, 25, 50 , 100 , 500 ],
              [ '10', '25', '50', '100' , '500']
          ],
  				buttons:[
  					{
    						extend: "pageLength",
                className: "btn blue btn-outline",
                text: "{{__('apps::dashboard.datatable.pageLength')}}",
                exportOptions: {
                    stripHtml : false,
                    columns: ':visible',
                    columns: [ 1 , 2 , 3 , 4 , 5]
                }
  					},
  					{
    						extend: "print",
                className: "btn blue btn-outline" ,
                text: "{{__('apps::dashboard.datatable.print')}}",
                exportOptions: {
                    stripHtml : false,
                    columns: ':visible',
                    columns: [ 1 , 2 , 3 , 4 , 5]
                }
  					},
  					{
  							extend: "pdf",
                className: "btn blue btn-outline" ,
                text: "{{__('apps::dashboard.datatable.pdf')}}",
                exportOptions: {
                    stripHtml : false,
                    columns: ':visible',
                    columns: [ 1 , 2 , 3 , 4 , 5]
                }
  					},
  					{
  							extend: "excel",
                className: "btn blue btn-outline " ,
                text: "{{__('apps::dashboard.datatable.excel')}}",
                exportOptions: {
                    stripHtml : false,
                    columns: ':visible',
                    columns: [ 1 , 2 , 3 , 4 , 5]
                }
  					},
  					{
  							extend: "colvis",
                className: "btn blue btn-outline",
                text: "{{__('apps::dashboard.datatable.colvis')}}",
                exportOptions: {
                    stripHtml : false,
                    columns: ':visible',
                    columns: [ 1 , 2 , 3 , 4 , 5]
                }
  					}
  				]
      });
  }

  jQuery(document).ready(function() {
  	tableGenerate();
  });
  </script>

@stop
