@extends('apps::dashboard.layouts.app')
@section('title', __('course::dashboard.lessons.routes.create'))
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
                    <a href="{{ url(route('dashboard.lessons.index')) }}">
                        {{__('course::dashboard.lessons.routes.index')}}
                    </a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="#">{{__('course::dashboard.lessons.routes.create')}}</a>
                </li>
            </ul>
        </div>

        <h1 class="page-title"></h1>

        <div class="row">
                {!! Form::model($model,[
                    'url'=> route('dashboard.lessons.store'),
                    'id'=>'form',
                    'role'=>'form',
                    'method'=>'POST',
                    'class'=>'form-horizontal form-row-seperated',
                    'files' => true
                    ])!!}
                <div class="col-md-12">

                    {{-- RIGHT SIDE --}}
                    <div class="col-md-3">
                        <div class="panel-group accordion scrollable" id="accordion2">
                            <div class="panel panel-default">


                                <div id="collapse_2_1" class="panel-collapse in">
                                    <div class="panel-body">
                                        <ul class="nav nav-pills nav-stacked">

                                            <li class="active">
                                                <a href="#general" data-toggle="tab">
                                                    {{ __('course::dashboard.lessons.form.tabs.general') }}
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
                            <div class="tab-pane active fade in" id="general">

                               
                             <div class="col-md-10">
                                   @include('course::dashboard.lessons.form')
                             </div>
                            </div>

                            {{-- PAGE ACTION --}}
                            <div class="col-md-12">
                                <div class="form-actions">
                                    @include('apps::dashboard.layouts._ajax-msg')
                                    <div class="form-group">
                                        <button type="submit" id="submit" class="btn btn-lg blue">
                                            {{__('apps::dashboard.buttons.add')}}
                                        </button>
                                        <a href="{{url(route('dashboard.lessons.index')) }}" class="btn btn-lg red">
                                            {{__('apps::dashboard.buttons.back')}}
                                        </a>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
        </div>
    </div>
</div>
@stop

@section('scripts')

<script type="text/javascript">
$(function() {
    $('#jstree').jstree();

    $('#jstree').on("changed.jstree", function(e, data) {
        $('#root_category').val(data.selected);
    });
});
</script>

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

<script>
    // GALLERY FORM / ADD NEW BUTTON UPLOAD
    $(document).ready(function() {
        var html = $("div.get-gallery-form").html();
        $(".add-gallery").click(function(e) {
            e.preventDefault();
            $(".gallery-form").append(html);
            $('.lfm').filemanager('image');
        });
    });

    // DELETE UPLOAD BUTTON
    $(".gallery-form").on("click", ".delete-gallery", function(e) {
        e.preventDefault();
        $(this).closest('.form-group').remove();
    });
</script>

@stop
