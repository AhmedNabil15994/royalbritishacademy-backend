@component('mail::message')
    {!!  __('course::frontend.emails.'.(string)$dif_in_days) !!}
    {!!  __('course::frontend.emails.days_left_until_the_end_of_your_course') !!}
    {{$title}}
    {!!  __('course::frontend.emails.subscription') !!}
    @component('mail::button', ['url' => $url])
        {!!  __('apps::frontend.emails.visit_site') !!}
    @endcomponent
    {{__('apps::frontend.emails.thanks')}},<br>{{ config('app.name') }}
@endcomponent
