

@inject('categories', 'Modules\Category\Entities\Category')
@inject('materials', 'Modules\Category\Entities\Material')

{!! field()->langNavTabs() !!}

<div class="tab-content">
  @foreach (config('laravellocalization.supportedLocales') as $code => $lang)
  <div class="tab-pane fade in {{ ($code == locale()) ? 'active' : '' }}" id="first_{{$code}}">
    {!! field()->text('title['.$code.']',
    __('course::dashboard.courses.form.title').'-'.$code ,
    $model->getTranslation('title' , $code),
    ['data-name' => 'title.'.$code]
    ) !!}
    {!! field()->ckEditor5('description['.$code.']',
    __('course::dashboard.courses.form.description').'-'.$code ,
    $model->getTranslation('description' , $code),
    ['data-name' => 'description.'.$code]
    ) !!}
    {!! field()->ckEditor5('requirements['.$code.']',
    __('course::dashboard.courses.form.requirements').'-'.$code ,
    $model->getTranslation('requirements' , $code),
    ['data-name' => 'requirements.'.$code]
    ) !!}
  </div>
  @endforeach
</div>


@if(! auth()->user()->can('trainer_access') && auth()->user()->can('dashboard_access'))
    {!! field()->select('trainer_id',__('course::dashboard.courses.form.trainers') , $trainers->pluck('name','id'))!!}
@else
    <input type="hidden" value="{{auth()->id()}}" name="trainer_id">
@endif

{!! field()->multiSelect('category_id',__('course::dashboard.courses.form.university') , $categories->pluck('title','id')->toArray(),$model?->categories()?->pluck('categories.id')?->toArray())!!}
{!! field()->multiSelect('material_id',__('course::dashboard.courses.form.materials') , $materials->pluck('title','id')->toArray(),$model?->materials()->count() ? $model?->materials()?->pluck('materials.id')?->toArray() : [])!!}


{!! field()->text('class_time', __('course::dashboard.courses.form.class_time').'/ Hrs') !!}
{!! field()->number('expire_after', __('course::dashboard.courses.form.expire_after')) !!}

{!! field()->file('introduction_video', __('course::dashboard.courses.form.intro_video')) !!}
@if ($model?->video?->loading_status == 'loaded')
    {!! $model->video->buildVideo() !!}
@elseif($model?->video?->loading_status == 'processing')

<div class="alert alert-warning" role="alert">
  @lang("Video is Processing")....
</div>
@endif

{!! field()->file('image', __('course::dashboard.courses.form.image'),$model->id?asset($model->image):null) !!}


{!! field()->number('price', __('course::dashboard.courses.form.price'),null,['step'=>'0.01']) !!}

<hr>

<div class="form-group">
    <label class="col-md-2">
        {{__('course::dashboard.courses.form.offer_status')}}
    </label>
    <div class="col-md-9">
        <input type="checkbox" class="isUnchecked" id="offer-status"
               name="offer_status" @if ($model?->offer)
               {{($model?->offer->status == 1) ? ' checked="" ' : ''}}
               @endif onclick="checkFunction()">
        <input type="hidden" class="isUnchecked" name="offer_status" value="0"
        @if($model?->offer)
            {{($model?->offer->status == 1) ? ' disabled ' : ''}}
                @endif>
        <div class="help-block"></div>
    </div>
</div>
<div class="offer-form" style="display:{{$model?->offer ? 'block' : 'none'}};">

  <div class="form-group">
      <label
              class="col-md-2">{{ __('course::dashboard.courses.form.offer_type.label') }}</label>
      <div class="col-md-9">
          <div class="mt-radio-inline">
              <label class="mt-radio">
                  <input type="radio" name="offer_type"
                         id="offerAmountRadioBtn"
                         value="amount" onclick="toggleOfferType('amount')"
                          {{ optional($model?->offer)->offer_price ? 'checked' : ''}}>
                  {{ __('course::dashboard.courses.form.offer_type.amount') }}
                  <span></span>
              </label>
              <label class="mt-radio">
                  <input type="radio" name="offer_type"
                         id="offerPercentageRadioBtn" value="percentage"
                         onclick="toggleOfferType('percentage')"
                          {{ optional($model?->offer)->percentage ? 'checked' : ''}}>
                  {{ __('course::dashboard.courses.form.offer_type.percentage') }}
                  <span></span>
              </label>
          </div>
          <div class="help-block"></div>
      </div>
  </div>

  <div class="form-group" id="offerAmountSection"
       style="display: {{ optional($model?->offer)->offer_price ? 'block':'none' }}">
      <label class="col-md-2">
          {{__('course::dashboard.courses.form.offer_price')}}
      </label>
      <div class="col-md-9">
          <input type="text" id="offer-form" name="offer_price"
                 class="form-control" data-name="offer_price"
                 value="{{ $model?->offer ? $model?->offer?->offer_price : ''}}">
          <div class="help-block"></div>
      </div>
  </div>

  <div class="form-group" id="offerPercentageSection"
       style="display: {{ optional($model?->offer)->percentage ? 'block':'none' }}">
      <label class="col-md-2">
          {{__('course::dashboard.courses.form.percentage')}}
      </label>
      <div class="col-md-9">
          <input type="number" step="0.5" min="0" id="offer-percentage-form"
                 name="offer_percentage" class="form-control"
                 data-name="offer_percentage"
                 value="{{ $model?->offer ? $model?->offer?->percentage : ''}}">
          <div class="help-block"></div>
      </div>
  </div>

  <div class="form-group">
      <label class="col-md-2">
          {{__('course::dashboard.courses.form.start_at')}}
      </label>
      <div class="col-md-9">
          <div class="input-group input-medium date date-picker"
               data-date-format="yyyy-mm-dd" data-date-start-date="+0d">
              <input type="text" id="offer-form" class="form-control"
                     name="start_at" data-name="start_at"
                     value="{{ $model?->offer ? $model?->offer->start_at : ''}}">
              <span class="input-group-btn">
              <button class="btn default" type="button">
                  <i class="fa fa-calendar"></i>
              </button>
          </span>
          </div>
          <div class="help-block"></div>
      </div>
  </div>
  <div class="form-group">
      <label class="col-md-2">
          {{__('course::dashboard.courses.form.end_at')}}
      </label>
      <div class="col-md-9">
          <div class="input-group input-medium date date-picker"
               data-date-format="yyyy-mm-dd" data-date-start-date="+0d">
              <input type="text" id="offer-form" class="form-control"
                     name="end_at"
                     data-name="end_at"
                     value="{{ $model?->offer ? $model?->offer->end_at  : ''}}">
              <span class="input-group-btn">
              <button class="btn default" type="button">
                  <i class="fa fa-calendar"></i>
              </button>
          </span>
          </div>
          <div class="help-block"></div>
      </div>
  </div>
</div>

<hr>

{!! field()->number('order', __('course::dashboard.lessoncontents.form.order')) !!}

{!! field()->checkBox('is_latest', __('course::dashboard.courses.form.latest')) !!}
{!! field()->checkBox('status', __('course::dashboard.courses.form.status')) !!}

@if ($model->trashed())
{!! field()->checkBox('trash_restore', __('course::dashboard.levels.form.restore')) !!}
@endif





@push('scripts')
<script type="text/javascript">
  $(function() {
        $('#jstree').jstree();

        $('#jstree').on("changed.jstree", function(e, data) {
            $('#root_category').val(data.selected);
        });
    });

    function toggleOfferType(type = '') {
            if (type === 'amount') {
                $('#offerAmountSection').show();
                $('#offerPercentageSection').hide();
                // $('input[name="offer_percentage"]').val('');
            } else if (type === 'percentage') {
                $('#offerPercentageSection').show();
                $('#offerAmountSection').hide();
                // $('input[name="offer_price"]').val('');
            }
        }

        // CHANGE STATUS OF CHECKBOX WITH 0 VALUE OR 1
        function checkFunction() {
            $('[name="offer_status"]').change(function () {
                if ($(this).is(':checked')){
                    $('.offer-form').show();
                    $(this).next().prop('disabled', true);
                  }else{
                    $('.offer-form').hide();
                    $(this).next().prop('disabled', false);
                  }
            });

            $('[name="arrival_status"]').change(function () {
                if ($(this).is(':checked'))
                    $(this).next().prop('disabled', true);
                else
                    $(this).next().prop('disabled', false);
            });

        }
</script>
@endpush
