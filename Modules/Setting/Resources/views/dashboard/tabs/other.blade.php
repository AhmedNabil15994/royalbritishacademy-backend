<div class="tab-pane fade" id="other">
  <h3 class="page-title">{{ __('setting::dashboard.settings.form.tabs.other') }}</h3>
  <div class="col-md-10">
    <div class="form-group">
      <label class="col-md-2">
        {{ __('setting::dashboard.settings.form.about_us') }}
      </label>
      <div class="col-md-9">
        <select name="other[about_us]" id="single" class="form-control select2">
          <option value=""></option>
          @foreach ($pages as $page)
          <option value="{{ $page['id'] }}" {{( setting('other','about_us')==$page->id) ? ' selected="" ' : ''}}>
            {{ $page->title }}
          </option>
          @endforeach
        </select>
      </div>
    </div>
    <div class="form-group">
      <label class="col-md-2">
        {{ __('setting::dashboard.settings.form.privacy_policy') }}
      </label>
      <div class="col-md-9">
        <select name="other[privacy_policy]" id="single" class="form-control select2">
          <option value=""></option>
          @foreach ($pages as $page)

          <option value="{{ $page['id'] }}" {{( setting('other','privacy_policy')==$page->id) ? ' selected="" ' : ''}}>
            {{ $page->title }}
          </option>
          @endforeach
        </select>
      </div>
    </div>
    <div class="form-group">
      <label class="col-md-2">
        {{ __('setting::dashboard.settings.form.terms') }}
      </label>
      <div class="col-md-9">
        <select name="other[terms]" id="single" class="form-control select2">
          <option value=""></option>
          @foreach ($pages as $page)
          <option value="{{ $page['id'] }}" {{(setting('other','terms')==$page->id) ? ' selected="" ' : ''}}>
            {{ $page->title }}
          </option>
          @endforeach
        </select>
      </div>
    </div>
  </div>
</div>
