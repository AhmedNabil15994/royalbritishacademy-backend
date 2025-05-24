@component('mail::message')

<h2>
  <center> {{ $data->getTranslation('title', 'en') .' '.'Welcomes you' }} </center>
</h2>


@component('mail::button', ['url' => url(route('frontend.home'))])

Browse now {{ $data->getTranslation('title', 'en') }}

@endcomponent
@endcomponent
