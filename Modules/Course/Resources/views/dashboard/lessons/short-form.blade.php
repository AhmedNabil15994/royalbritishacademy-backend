
@inject('semesters', 'Modules\Semester\Entities\Semester')
<form id="new-reservation-modal-form">
  {!! field()->langNavTabs('new-nav') !!}
  <div class="tab-content">
    @foreach (config('laravellocalization.supportedLocales') as $code => $lang)
    <div class="tab-pane fade in {{ ($code == locale()) ? 'active' : '' }}" id="new-nav_{{$code}}">
      {!! field()->text('title['.$code.']',
      __('course::dashboard.lessons.form.title').'-'.$code ,null,['data-name' => 'title.'.$code]
      ) !!}
    </div>
    @endforeach
  </div>

  {!! field()->select('course_id',__('course::dashboard.lessons.form.courses') , $courses->pluck('title','id'), ) !!}
  {!! field()->select('semester_id',__('course::dashboard.lessons.form.semesters') , $semesters->active()->pluck('title','id') ) !!}
  <input type="hidden" name="status" value="on">
</form>

@push('scripts')
<script>
  $.ajaxSetup({
    headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });
  let url="{{ route('dashboard.lessons.store') }}"
  $('#extra-lesson-btn').click(function(e) {
            e.preventDefault();
            let formData = new FormData($('#new-reservation-modal-form')[0]);


           $.ajax({
              xhr: function () {
              var xhr = new window.XMLHttpRequest();
              xhr.upload.addEventListener("progress", function (evt) {
                  if (evt.lengthComputable) {
                      var percentComplete = evt.loaded / evt.total;
                      percentComplete = parseInt(percentComplete * 100);
                      $('.progress-bar').width(percentComplete + '%');
                      $('#progress-status').html(percentComplete + '%');
                  }
                   }, false);
                  return xhr;
              },
              type: "post",
              url: url,
              data: formData,
              cache: false,
              processData: false,
              contentType: false,
              dataType: "json",
              beforeSend: function () {
                  $('#confirm').prop('disabled', true);
                  $('.progress-info').show();
                  $('.progress-bar').width('0%');
                  resetErrors();
              },
              success:  (data)=> {
                  $('#extraLesson').modal('hide')
                  $('#extra-lesson-btn').prop('disabled', false);
                  $('#submit').text();
                  if (data[0] == true) {
                      successfully(data);
                      $("#lesson_id").select2("destroy");

                      $.ajax({
                        type: "get",
                        url: "{{ route('dashboard.get-courses-ajax') }}",
                        data: "data",
                        dataType: "json",
                        success: function (response) {
                          console.log(response);
                          let options='';
                          $('#lesson_id').html('')
                            $.each(response, function (index, course) {
                              $('#lesson_id').append(`
                                  <optgroup label="${course['title']}">
                                       ${
                                        $.each(course['lessons'],
                                        function (index, lesson) {
                                            options +=  `<option value="${lesson.id}">${lesson.title}</option>`
                                           })
                                      }

                                      ${options}
                                  </optgroup>
                              `)
                            });

                            $("#lesson_id").select2();
                         }

                        });

                      // $("#dropdown").select2();
                  } else {
                      displayMissing(data);
                  };
              },
              error: function (data) {
                  $('#extra-lesson-btn').prop('disabled', false);
                  displayErrors(data);
              },
           });


        })




</script>
@endpush
