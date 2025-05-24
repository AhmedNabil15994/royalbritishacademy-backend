@extends('apps::frontend.layouts.app')
@section('title', __('semester::frontend.index.title') )
@section('content')
<section class="page-head align-items-center text-center d-flex">
    <div class="container">
        <h1>{{__('semester::frontend.index.title')}}</h1>
    </div>
</section>
<div class="inner-page grey-bg">
    <div class="container">
        <div class="row">

            @foreach ($semesters as $semester)
            <div class="col-md-4 wow fadeInUp">
                <div class="podcast-block">
                    <div class="img-block">
                        <img class="img-fluid" src="{{ url($semester->image) }}" />
                    </div>
                    <div class="podcast-content semester-content">
                        <h3>
                            <a class="bodcast-title" href="{{route('frontend.semesters.show',$semester->slug)}}">
                                {{ $semester->title }}
                            </a>
                        </h3>
                        <ul class="post-footer">
                            <li>{{__('semester::frontend.by')}}: {{optional($semester->trainer)->name}}</li>
                            <li>{{ date('M' , strtotime($semester->created_at)) }}</li>
                        </ul>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        @include('apps::frontend.layouts.components.paginations',['paginator' => $semesters])
    </div>
</div>
@stop
