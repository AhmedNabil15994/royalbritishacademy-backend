@foreach (config('laravellocalization.supportedLocales') as $localeCode => $properties)
@if ($localeCode != locale())
<a href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">{{ $properties['native'] }}</a>
@endif
@endforeach
