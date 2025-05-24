@extends('apps::frontend.layouts.app')
@section('title', __('order::frontend.show.Checkout'))
@push('social_scripts')
<!-- Meta Pixel Code -->
<script>
  !function(f,b,e,v,n,t,s)
  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
  n.queue=[];t=b.createElement(e);t.async=!0;
  t.src=v;s=b.getElementsByTagName(e)[0];
  s.parentNode.insertBefore(t,s)}(window, document,'script',
  'https://connect.facebook.net/en_US/fbevents.js');
  fbq('init', '3487768754790238');
  fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
  src="https://www.facebook.com/tr?id=3487768754790238&ev=PageView&noscript=1"
/></noscript>
<!-- End Meta Pixel Code -->
@endpush
@section('content')
<section class="course-one course-page bg-color-dark">
    <div class="container">
      <div class="row">
        <div class="col">
            <div class="course-one__single course-category-one__single color-1">
                <img src="{{asset('frontend/assets/images/order-approved.png')}}" />
                <div class="course-one__content">
                    <h2 class="course-one__title">@lang("You have successfully completed your order")</h2>
                </div>
            </div>
        </div>
      </div>
    </div>
  </section>
@stop
