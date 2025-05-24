@inject('courses' ,'Modules\Course\Entities\Course')

{!! field()->langNavTabs() !!}

<div class="tab-content">
    @foreach (config('laravellocalization.supportedLocales') as $code => $lang)
    <div class="tab-pane fade in {{ ($code == locale()) ? 'active' : '' }}"
        id="first_{{$code}}">
        {!! field()->text('title['.$code.']',
        __('slider::dashboard.sliders.form.title').'-'.$code ,
        $model->getTranslation('title',$code),
        ['data-name' => 'title.'.$code]
        ) !!}
        {!! field()->ckEditor5('description['.$code.']',
        __('slider::dashboard.sliders.form.description').'-'.$code ,
        $model->getTranslation('description',$code),
        ['data-name' => 'description.'.$code]
        ) !!}
    </div>
    @endforeach
</div>


<div class="form-group">
    <label class="col-md-2">
        {{__('slider::dashboard.sliders.form.link_type')}}
    </label>

    <div class="col-md-9">
        <div class="md-radio-inline">
            <label class="mt-radio">
                <input type="radio"
                    name="type"
                    id="type"
                    value="course"
                    {{$model->type == 'course' ? 'checked="checked"' : ''}}>
                {{__('slider::dashboard.sliders.form.course')}}
                <span></span>
            </label>

            <label class="mt-radio">
                <input type="radio"
                    name="type"
                    id="type"
                    value="link"
                    {{!$model->type || $model->type == 'link' ? 'checked="checked"' : ''}}>
                {{__('slider::dashboard.sliders.form.external_link')}}
                <span></span>
            </label>

        </div>
        <div class="help-block"></div>
    </div>
</div>

<div class=" hide-inputs"
    id="course-input"
    style="display: {{$model->type == 'course' ? 'block' : 'none'}}">
    {!! field()->select('course_id',__('slider::dashboard.sliders.form.course') ,
    $courses->pluck('title','id')->toArray(), null , ['id' => 'single']) !!}
</div>


<div class=" hide-inputs"
    id="link-input"
    style="display: {{!$model->type || $model->type == 'link' ? 'block' : 'none'}}">
    {!! field()->text('link', __('slider::dashboard.sliders.form.link'), null,['autocomplete' => 'off']) !!}
</div>
<div class="clearfix"></div>

{!! field()->checkBox('add_dates' , __('slider::dashboard.sliders.form.add_dates'),null,['class' => '']) !!}

<div id="dates_container"
    style="display: none;">
    {!! field()->date('start_date', __('slider::dashboard.sliders.form.start_date'),
    $model->start_date ? \Carbon\Carbon::parse($model->start_date)->format('Y-m-d'): null) !!}
    {!! field()->date('end_date', __('slider::dashboard.sliders.form.end_date'),
    $model->end_date ? \Carbon\Carbon::parse($model->end_date)->format('Y-m-d'): null) !!}
</div>

{!! field()->number('order', __('slider::dashboard.sliders.form.order')) !!}
{!! field()->file('image', __('slider::dashboard.sliders.form.image'), $model->getFirstMediaUrl('images')) !!}
{!! field()->checkBox('status', __('slider::dashboard.sliders.form.status')) !!}


@if ($model->trashed())
{!! field()->checkBox('trash_restore', __('slider::dashboard.sliders.form.restore')) !!}
@endif



@push('scripts')
<script>
    $('input[name=type]').change(function () {
            $('.hide-inputs').hide();
            $('#' + this.value + '-input').show();
        });
        $('#add_dates').change(function () {
            if (this.checked) {
                $('#dates_container').show();
            }else{

                $('#dates_container').hide();
            }
        });
</script>
@endpush
