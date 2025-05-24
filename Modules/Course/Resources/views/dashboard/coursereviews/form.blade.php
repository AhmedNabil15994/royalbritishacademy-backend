{!! field()->text('stars', __('course::dashboard.coursereviews.form.stars',)) !!}
{!! field()->text('desc', __('course::dashboard.coursereviews.form.desc')) !!}
{!! field()->checkBox('status', __('course::dashboard.coursereviews.form.status')) !!}

<h1>{{ __('course::dashboard.coursereviews.form.answers') }}</h1>
<table class="table table-hover">
  <thead>
    @foreach($model->reviewQuestionAnswer->load('reviewQuestion') as $key => $answer)
    <tr>
      <th class="text-left bold">
        {{$answer->reviewQuestion->title}}
      </th>
      <th></th>
      <th></th>
      <th class="text-left bold">
        {{ $answer->answer==1?__('course::dashboard.coursereviews.form.yes'):__('course::dashboard.coursereviews.form.no') }}
      </th>
    </tr>
    @endforeach
  </thead>
</table>
