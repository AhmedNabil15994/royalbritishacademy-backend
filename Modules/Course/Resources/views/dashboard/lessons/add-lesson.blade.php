<div class="modal fade"
  id="extraLesson"
  tabindex="-1"
  role="dialog"
  aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog"
    role="document">
    <div class="modal-content">
      <div class="modal-body">
        @include('course::dashboard.lessons.short-form')
      </div>
      <div class="modal-footer">
        <button type="button"
          class="btn btn-primary" id="extra-lesson-btn">{{ __('apps::dashboard.buttons.add') }}</button>
      </div>
    </div>
  </div>
</div>
