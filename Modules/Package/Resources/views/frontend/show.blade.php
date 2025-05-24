@extends('apps::frontend.layouts.app')
@section( 'title',$package->title)
@section( 'content')
<section class="inner-banner">
    <div class="container">
        <ul class="list-unstyled thm-breadcrumb">
          <li><a href="{{route('frontend.home')}}">{{ __('Home') }}</a></li>
            <li class="active"> {{$package->title}}</li>
        </ul>
    </div>
</section>


<section class="pricing-one pricing-page bg-color-dark">
  <div class="container">
      <div class="pricing-one__header text-center">
          <h2 class="header-title">{{$package->title}}</h2>
      </div>

      @php
        $courses = $package->courses()->active()->get(['id','title','slug']);
        $notes = $package->notes()->active()->get(['id','title']);
      @endphp
      @if($courses)
        <h2 class="header-title">
          <div class="course-details__meta-icon flag-icon"> <i class="fas fa-flag"></i></div> {{ __('Materials') }}
        </h2>
        <div class="pricing-one__header text-center"> 
          <div class="offer-content">
            <ul class="list-unstyled">
              @foreach($courses as $course)
                <li><a href="{{ route('frontend.courses.show',['slug'=>$course->slug]) }}">{{$course->title}}</a></li>
              @endforeach
            </ul>
          </div>
        </div>
      @endif
      <hr>
      @if($notes)
        <h2 class="header-title">
          <div class="course-details__meta-icon flag-icon"> <i class="fas fa-flag"></i></div> {{ __('Printed Notes') }}
        </h2>
        <div class="pricing-one__header text-center"> 
          <div class="offer-content">
            <ul class="list-unstyled">
              @foreach($notes as $note)
                <li><a>{{$note->title}}</a></li>
              @endforeach
            </ul>
          </div>
        </div>
      @endif
      <div class="pricing-one__header text-center"> 
        <div class="offer-content">
          <p>{!! $package->description !!}</p>
        </div>
        <h2 class="header-title">@lang("Choose the duration of the package")</h2>
      </div>
      <hr>
      <div class="row justify-content-center">
        @foreach($package->prices as $price)
          <div class="col-lg-4">
              <div class="pricing-one__single">
                  <div class="pricing-one__inner">
                      <div class="style-pricing">
                          @if($price->has_offer_know)
                            <del>
                                <span class="amount">{{$price->price}} @lang("KWD")</span>
                            </del>
                            <ins>
                                <span class="amount pricing-one__price">{{calculateOfferAmountByPercentage($price->price,$price->offer_percentage)}} @lang("KWD")</span>
                            </ins>
                          @else
                            <ins>
                                <span class="amount pricing-one__price">{{$price->price}} @lang("KWD")</span>
                            </ins>
                          @endif
                      </div>
                      <p class="pricing-one__name">{{$price->title}}</p>
                      <ul class="pricing-one__list list-unstyled">
                        @foreach(explode(',',$price->subscribe_duration_desc) as $line)
                          <li>{{$line}}</li>
                        @endforeach
                      </ul>
                      <a href="{{ route('frontend.cart.add',['id'=> $price->id,'type'=>'package']) }}" class="thm-btn pricing-one__btn">@lang("Select package")</a>
                  </div>
              </div>
          </div>
        @endforeach
      </div>
  </div>
</section>

@endsection
