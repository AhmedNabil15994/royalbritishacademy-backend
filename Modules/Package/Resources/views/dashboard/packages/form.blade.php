{!! field()->langNavTabs() !!}

<div class="tab-content">
  @foreach (config('laravellocalization.supportedLocales') as $code => $lang)
  <div class="tab-pane fade in {{ $code == locale() ? 'active' : '' }}" id="first_{{ $code }}">
    {!! field()->text(
    'title[' . $code . ']',
    __('package::dashboard.packages.form.title') . '-' . $code,
    $model->getTranslation('title', $code),
    ['data-name' => 'title.' . $code],
    ) !!}
    {!! field()->ckEditor5(
    'description[' . $code . ']',
    __('package::dashboard.packages.form.description') . '-' . $code,
    $model->getTranslation('description', $code),
    ['data-name' => 'description.' . $code,'class' => 'form-control'],
    ) !!}
  </div>
  @endforeach
</div>

{!! field()->select('settings[category_id]',__('package::dashboard.packages.form.categories'),$categories) !!}



{!! field()->multiSelect('settings[courses]',__('course::dashboard.lessons.form.courses'),$model->courses ? $model->courses->pluck('title', 'id')->toArray()
:[],null,
['class' => 'form-control select2-ajax-courses ignore-reset']) !!}




{!! field()->multiSelect('settings[notes]',__('package::dashboard.packages.form.notes'),$model->notes ? $model->notes->pluck('title', 'id')->toArray()
:[],null,
['class' => 'form-control select2-ajax-notes']) !!}

{!! field()->file('image', __('package::dashboard.packages.form.image'),$model->getFirstMediaUrl('images')) !!}
{!! field()->checkBox('is_free', __('package::dashboard.packages.form.is_free')) !!}

{!! field()->checkBox('status', __('package::dashboard.packages.form.status')) !!}

@if ($model->trashed())
{!! field()->checkBox('trash_restore', __('apps::dashboard.datatable.form.restore')) !!}
@endif



@push('scripts')
<script>
  $('#is_free').bootstrapSwitch({
      onInit:function (e, state){
        if($(this).is(':checked')){
         $('.prices').hide()
        }
        },
        onSwitchChange: function (e, state) {
          $('.prices').toggle()
      }
  });
  $(document).ready(function() {
      loadCourses()
      loadNotes()
      })


      $('[name="settings[category_id]"]').change(function(){
        $(".select2-ajax-notes option:selected").removeAttr("selected");
        $(".select2-ajax-courses option:selected").removeAttr("selected");
          loadCourses()
          loadNotes()
      })



function loadCourses(){
 $(".select2-ajax-courses").select2({
            ajax: {
                url: "{{ route('dashboard.get-courses-ajax') }}",
                data: function(params) {
                var query = {
                  search: params.term,
                  category_id:$('[name="settings[category_id]"]').val(),
                  page: params.page || 1
                }
                // Query parameters will be ?search=[term]&type=public
                 return query;
                },
                processResults: function(data, params) {
                params.page = params.page || 1;

                var results = data.map(function(object) {
                      return {
                        id  : object.id,
                        text: object.title
                      }
                })
                // Transforms the top-level key of the response object from 'items' to 'results'
                return {
                      results: results,
                  };
                 }
                }
            });
}

function loadNotes(){
    $(".select2-ajax-notes").select2({
                  ajax: {
                  url: "{{ route('dashboard.get-notes-ajax') }}",
                  data: function(params) {
                  var query = {
                      search: params.term,
                      category_id:$('[name="settings[category_id]"]').val(),
                      page: params.page || 1
                  }
                  // Query parameters will be ?search=[term]&type=public
                  return query;
                  },
                  processResults: function(data, params) {
                  params.page = params.page || 1;
                    var results = data.map(function(object) {
                    return {
                        id : object.id,
                        text: object.title
                    }
                  })
                  // Transforms the top-level key of the response object from 'items' to 'results'
                  return {results: results};
                  }
                  }
            });
}



</script>
@endpush
