<div class="tab-pane fade in"
    id="availabilities">
    <div class="col-md-12">

        {!! field()->datetime('extra_attributes[start_date]', __('course::dashboard.courses.form.start_date')) !!}
        {!! field()->datetime('extra_attributes[end_date]', __('course::dashboard.courses.form.end_date')) !!}
        {!! field()->number('extra_attributes[duration]', __('course::dashboard.courses.form.duration')) !!}

        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ __('course::dashboard.courses.form.available_days') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach (getDays() as $k => $day)
                    @php
                    $days = explode(',',$model->extra_attributes->get('days', ''));
                    @endphp
                    <tr>
                        <td>
                            <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                <input type="checkbox"
                                    {{
                                    in_array($k,$days)
                                    ? 'checked'
                                    : ''
                                    }}
                                    class="group-checkable"
                                    value="{{ $k }}"
                                    name="days_status[]">
                                <span></span>
                            </label>
                        </td>
                        <td>
                            {{ $day }}
                        </td>


                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
