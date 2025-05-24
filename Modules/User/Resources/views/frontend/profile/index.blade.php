@extends('apps::frontend.layouts.app')
@section('title', __('Profile') )
@section('content')
<section class="inner-banner">
  <div class="container">
    <ul class="list-unstyled thm-breadcrumb">
      <li><a href="{{ route('frontend.home') }}">{{ __('Home') }} </a></li>
      <li class="active"><a href="#">@lang("Profile")</a></li>
    </ul>
  </div>
</section>

<section class="course-details account print-file bg-color-dark">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="course-details__meta detials">
                    <div class="course-details__meta-link">
                        <div class="course-details__meta-icon">
                            <i class="far fa-user-circle"></i>
                        </div>
                        @lang("Email"): <span>{{auth()->user()->email}}</span>
                    </div>
                    <div class="course-details__meta-link">
                        <div class="course-details__meta-icon">
                            <i class="far fa-user-circle"></i>
                        </div>
                        @lang("Phone"): <span dir="ltr">{{auth()->user()->mobile}}</span>
                    </div>
                    @if (auth()->user()->address)
                        <div class="course-details__meta-link">
                            <div class="course-details__meta-icon">
                                <i class="fas fa-user-circle"></i>
                            </div>
                            @lang("Address"):
                            <span>
                                    @lang(auth()->user()->address->type).
                                @if(auth()->user()->address->region)
                                @lang("Region") {{auth()->user()->address->region}},
                                @endif
                                @if(auth()->user()->address->street)
                                @lang("Street") {{auth()->user()->address->street}},
                                @endif
                                @if(auth()->user()->address->gada)
                                @lang("Avenue") {{auth()->user()->address->gada}},
                                @endif
                                @if(auth()->user()->address->widget)
                                @lang("Widget") {{auth()->user()->address->widget}},
                                @endif
                                @if(auth()->user()->address->details)
                                {{auth()->user()->address->details}}
                                @endif
                            </span>
                        </div>
                        {{-- <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3476.6499128547307!2d47.97982248505843!3d29.38053818212872!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3fcf84f275ddcfcf%3A0x87d8d20a5721f52c!2z2LTYp9ix2Lkg2KfYqNmI2LnYqNmK2K_YqSDYqNmGINin2YTYrNix2KfYrdiMINmF2K_ZitmG2Kkg2KfZhNmD2YjZitiq2Iwg2KfZhNmD2YjZitiq4oCO!5e0!3m2!1sar!2seg!4v1673396907475!5m2!1sar!2seg" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe> --}}
                    @endif
                    </div>

            </div>
            <div class="col-lg-4">
                @include("user::frontend.profile.components.sidebar")
            </div>
        </div>
    </div>
</section>

@stop
