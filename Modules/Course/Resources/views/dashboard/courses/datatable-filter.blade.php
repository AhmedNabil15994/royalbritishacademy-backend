@inject('categories', 'Modules\Category\Entities\Category')
@inject('materials', 'Modules\Category\Entities\Material')
@inject('trainers', 'Modules\Trainer\Entities\Trainer')

<div class="col-md-3">
  <div class="form-group">
    <label class="control-label">
      {{
      __('course::dashboard.courses.datatable.categories')
      }}
    </label>
    <select name="categories"
      id="categories_single"
      class="form-control select2">
      <option value="">
        {{__('course::dashboard.courses.datatable.categories')}}
      </option>
      @foreach ($categories->active()->get() as $category)
      <option value="{{ $category->id }}">
        {{ $category->title }}
      </option>
      @endforeach
    </select>
  </div>
</div>
<div class="col-md-3">
  <div class="form-group">
    <label class="control-label">
      {{
      __('course::dashboard.courses.datatable.materials')
      }}
    </label>
    <select name="material"
      id="material_single"
      class="form-control select2">
      <option value="">
        {{__('course::dashboard.courses.datatable.material')}}
      </option>
      @foreach ($materials->active()->get() as $material)
      <option value="{{ $material->id }}">
        {{ $material->title }}
      </option>
      @endforeach
    </select>
  </div>
</div>

@if(! auth()->user()->can('trainer_access') && auth()->user()->can('dashboard_access'))
<div class="col-md-3">
  <div class="form-group">
    <label class="control-label">
      {{__('course::dashboard.courses.form.trainers')}}
    </label>
    <select name="trainer"
      id="trainer_single"
      class="form-control select2">
      <option value="">
        {{__('course::dashboard.courses.form.trainers')}}
      </option>

      @foreach ($trainers->filterTrainer()->get() as $trainer)
      <option value="{{ $trainer->id }}">
        {{ $trainer->name }}
      </option>
      @endforeach
    </select>
  </div>
</div>
@endif


