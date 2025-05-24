@extends('apps::frontend.layouts.app')
@section('title', __('Courses') )
@section('content')
<div class="inner-page grey-bg">
  <div class="container">
    <div class="row">
      @include('course::frontend.courses.index-partials.sidebar')
      <div class="col-md-9">
        <div class="courses-block">
          <div class="row">
            @foreach($courses as $key => $course)
            <div class="col-md-4 col-6 py-4">
              @includeIf('course::frontend.courses.components.single-course')
            </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
@push('plugins-scripts')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
@endpush

@push('scripts')
<script>
  // Slider range price

        $('.slider-range-price').each(function () {
            var min = parseInt($(this).data('min'));
            var max = parseInt($(this).data('max'));
            var unit = $(this).data('unit');
            var value_min = parseInt($(this).data('value-min'));
            var value_max = parseInt($(this).data('value-max'));
            var label_reasult = $(this).data('label-reasult');
            var t = $(this);
            $(this).slider({
                range: true,
                min: min,
                max: max,
                values: [value_min, value_max],
                slide: function (event, ui) {
                    var result = label_reasult + " <span>" + unit + ui.values[0] + ' </span> - <span> ' + unit + ui.values[1] + '</span>';
                    t.closest('.price_slider_wrapper').find('.price_slider_amount').html(result);
                    /************* Edited By Mahmoud Elzohairy **************/
                    t.closest('.price_slider_wrapper').find('#hiddenPriceSliderAmount #priceFrom').val(ui.values[0]);
                    t.closest('.price_slider_wrapper').find('#hiddenPriceSliderAmount #priceTo').val(ui.values[1]);
                }
            });
        });
</script>

@endpush
