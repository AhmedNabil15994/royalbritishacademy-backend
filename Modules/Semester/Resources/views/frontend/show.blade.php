@extends('apps::frontend.layouts.app')
@section('title', $semester->title)
@section('content')
<section class="page-head align-items-center text-center d-flex">
    <div class="container">
        <h1>{{ __('semester::frontend.index.title')}} / {{ $semester->title }}</h1>
    </div>
</section>
<div class="inner-page grey-bg">
    <div class="container">
        <div class="semester-post">
            <div class="img-block">
                <img class="img-fluid" src="{{url($semester->image)}}" />
            </div>
            <div class="semester-content">
                <h2>{{$semester->title}}</h2>
                <ul class="post-footer">
                    <li>{{__('semester::frontend.by')}}: {{optional($semester->trainer)->name}}</li>
                    <li>
                        {{ date('M,d Y' , strtotime($semester->created_at)) }}
                    </li>
                </ul>
                <div class="post-content">
                    {!! $semester->description !!}
                </div>
            </div>
        </div>
    </div>
</div>
@stop
