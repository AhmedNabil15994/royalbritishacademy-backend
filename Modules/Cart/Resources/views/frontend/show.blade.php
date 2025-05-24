@extends('apps::frontend.layouts.app')
@section('title', __('cart::frontend.show.title') )
@section('content')
<section class="inner-banner">
  <div class="container">
    <ul class="list-unstyled thm-breadcrumb">
      <li><a href="{{route('frontend.home')}}">{{ __('Home') }}</a></li>
      <li class="active"> {{ __('Shopping Cart') }}</li>
    </ul>
  </div>
</section>
<section class="course-one course-page cart bg-color-dark ">
  @include('apps::frontend.layouts._alerts')
  @if (count($items))
    <div class="container">
      <h2 class="header-title">
        <div class="course-details__meta-icon flag-icon"> <i class="fas fa-shopping-bag"></i></div>
        {{ __('Shopping Cart') }}
      </h2>
      <div class="row justify-content-center">
          @foreach ($items as $item)
            <div class="col-lg-4">
              <div class="course-one__single shap">
                <div class="course-one__image">
                  <img src="{{ $item->attributes->image }}" alt="">
                </div>
                <div class="course-one__content">
                  <div class="course-one__category"> {{$item->attributes->product['category']}} </div>
                  <h2 class="course-one__title title-name">{{$item->attributes->product['title']}}</h2>
                  <h2 class="pricing-one__price">{{ $item->price }} {{ __('KWD') }} </h2>
                  <p class="pricing-one__name">{{$item->attributes->product['sub_title'] }}</p>
                </div>
              </div>
              <span><a class="link-dark" style="color: white" href="{{route('frontend.cart.remove',[$item->attributes->type, $item->attributes->item_id])}}">x</a></span>
            </div>
          @endforeach
        

      </div>
      <hr>
      <div class="row justify-content-center">
        <div class="col-lg-6">
          {!! Form::open([
            'url'=> route('frontend.order.create'),
            'role'=>'form',
            'class'=>'course-details__comment-form copon_code',
            'id'=>'cart_form',
            'method'=>'POST',
            ])!!}
              <div class="row justify-content-center">
                <div class="col-lg-12">
                  <input type="text" name="coupon_code" placeholder="{{ __('Enter the Coupon Code') }}">
                </div>
              </div>
            {!! Form::close()!!}
        </div>
      </div>
      <div class="row justify-content-center">
        <div class="col-lg-6">
          <div class="pricing-one__single text-center">
            <div class="pricing-one__inner">
              <h2 class="pricing-one__price">{{ Cart::getTotal() }} {{ __('KWD') }} </h2>
              <p class="pricing-one__name">{{ __('Total Cost') }}</p>
            </div>
          </div>
        </div>
      </div>
      <div class="row justify-content-center">
        <div class="col-lg-6">
          <a onclick="submitCourseForm(this,'cart_form')" class="thm-btn banner-one__btn" style="color: white;cursor:pointer">{{ __('Payment') }}</a>
        </div>
      </div>
    </div>
  @else
    <div class="alert alert-danger" role="alert" style="text-align: center;">
      @lang("No Data Found")
    </div>
  @endif
</section>
@include("course::frontend.courses.components.buy-course-script")
@stop
