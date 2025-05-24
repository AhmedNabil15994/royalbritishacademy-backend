@extends('apps::dashboard.layouts.app')
@section('title', __('course::dashboard.courses.routes.update'))
@section('content')
<div class="page-content-wrapper">
  <div class="page-content">
    <div class="page-bar">
      <ul class="page-breadcrumb">
        <li>
          <a href="{{ route('dashboard.home') }}">{{ __('apps::dashboard.index.title') }}</a>
          <i class="fa fa-circle"></i>
        </li>
        <li>
          <a href="{{ url(route('dashboard.courses.index')) }}">
            {{ __('course::dashboard.courses.routes.index') }}
          </a>
          <i class="fa fa-circle"></i>
        </li>
        <li>
          <a href="#">{{ __('course::dashboard.courses.routes.update') }}</a>
        </li>
      </ul>
    </div>

    <h1 class="page-title"></h1>

    <div class="row">
      {!! Form::model($model, [
      'url' => route('dashboard.courses.update', $model->id),
      'id' => 'updateForm',
      'role' => 'form',
      'method' => 'PUT',
      'class' => 'form-horizontal form-row-seperated',
      'files' => true,
      ]) !!}



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
                        {{ __('course::dashboard.courses.form.tabs.general') }}
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

            {{-- UPDATE FORM --}}
            <div class="tab-pane active fade in"
              id="global_setting">

              <div class="col-md-10">
                @include('course::dashboard.courses.forms.form')
              </div>
            </div>


            <div class="col-md-12">
              <div class="form-actions">
                @include('apps::dashboard.layouts._ajax-msg')
                <div class="form-group">
                  <button type="submit"
                    id="submit"
                    class="btn btn-lg green">
                    {{ __('apps::dashboard.buttons.edit') }}
                  </button>
                  <a href="{{ url(route('dashboard.courses.index')) }}"
                    class="btn btn-lg red">
                    {{ __('apps::dashboard.buttons.back') }}
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



@push('scripts')
<script>
  // GALLERY FORM / ADD NEW BUTTON UPLOAD
        $(document).ready(function() {
            var html = `
                                            <div class="form-group">
                                                <label class="col-md-2">
                                                    {{ __('course::dashboard.courses.form.image') }}
                                                </label>
                                                <div class="input-group col-md-9">
                                                <span class="input-group-btn">
                                                    <a data-input="images" data-preview="holder"
                                                       class="btn btn-primary lfm">
                                                        <i class="fa fa-picture-o"></i>
                                                        {{ __('apps::dashboard.buttons.upload') }}
                                                    </a>
                                                </span>
                                                    <input name="images[]" class="form-control images" type="text"
                                                           readonly>
                                                    <span class="input-group-btn">
                                                    <a data-input="images" data-preview="holder"
                                                       class="btn btn-danger delete-gallery">
                                                        <i class="glyphicon glyphicon-remove"></i>
                                                    </a>
                                                </span>
                                                </div>
                                                <span class="holder" style="margin-top:15px;max-height:100px;"></span>
                                            </div>
                                        `;
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
@endpush
