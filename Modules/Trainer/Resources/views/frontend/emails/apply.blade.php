@component('mail::message')

<h2> <center> {{ __('Instructor Apply Request') }} </center> </h2>

<ul>
  <li>Username      : {{ $request['username'] }}</li>
  <li>Mobile        : {{ $request['mobile'] }}</li>
  <li>Email         : {{ $request['email'] }}</li>
</ul>


@endcomponent
