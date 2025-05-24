@extends('apps::frontend.layouts.app')
@section('title', __('Update Profile') )
@section('content')
<section class="inner-banner">
  <div class="container">
    <ul class="list-unstyled thm-breadcrumb">
      <li><a href="{{ route('frontend.home') }}">{{ __('Home') }} </a></li>
      <li class="active"><a href="#">@lang("Update Profile")</a></li>
    </ul>
  </div>
</section>

<section class="course-details account print-file bg-color-dark">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <section class="contact-one items">
                    <div class="container">
                        @include('apps::frontend.layouts._alerts')
                        {!! Form::open([
                            'url'=> route('frontend.profile.update'),
                            'method'=>'POST',
                            'class'=>'contact-one__form',
                            'files' => true,
                            'novalidate' => ''
                            ])!!}
                            <div class="row low-gutters">
                                {!! field('auth')->text('name',__('Name'),auth()->user()->name)!!}
                                {!! field('auth')->email('email',__('Email'),auth()->user()->email)!!}
                                
                                 <div class="col-lg-12">
                                    <label>@lang("Address")</label>
                                </div>
                                
                                {!! field('auth')->text('region',__('Region'),optional(auth()->user()->address)->region)!!}
                                {!! field('update_address')->select('address_type',__('Address Type'),[
                                    'house' => __('House'),
                                    'school' => __('School'),
                                    'villa' => __('Villa'),
                                ],optional(auth()->user()->address)->type)!!}

                                {!! field('update_address')->text('street',__('Street'),optional(auth()->user()->address)->street)!!}
                                {!! field('update_address')->text('gada',__('Avenue (if any)'),optional(auth()->user()->address)->gada)!!}
                                {!! field('update_address')->text('widget',__('Widget'),optional(auth()->user()->address)->widget)!!}
                                
                                <div class="col-lg-12">
                                    <textarea style="height: auto;" placeholder="@lang("More Details")" name="details">{{optional(auth()->user()->address)->details}}</textarea>
                                </div>
                                
                                <div class="col-lg-12">
                                    <div class="text-center">
                                        <button type="submit" class="contact-one__btn thm-btn">@lang("Save")</button>
                                    </div>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        <div class="result text-center"></div>
                    </div>
                </section>
            </div>
            
            
            <div class="col-lg-4">
                @include("user::frontend.profile.components.sidebar")
            </div>
        </div>
    </div>
</section>

@stop
