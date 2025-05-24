


@push('scripts')
  <script>
    function submitCourseForm(btn,id){
      $(btn).prop('disabled',true);
      $(`#${id}`).submit();
    }
  </script>
@endpush