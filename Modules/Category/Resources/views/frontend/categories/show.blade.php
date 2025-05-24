@extends('apps::frontend.layouts.app')

@section('title',$category->title)
@section( 'content')
<section class="inner-banner">
  <div class="container">
    <ul class="list-unstyled thm-breadcrumb">
      <li><a href="{{ route('frontend.home') }}">{{ __('Home') }}</a></li>
      <li class="active"><a href="{{ route('frontend.categories.show',['category'=>$category->id]) }}">{{ $category->title }}</a></li>
    </ul>
  </div>
</section>
<section class="course-one course-page bg-color-dark">
  <div class="container">
    <div class="row">
      @foreach($category->children()->active()->orderBy('order','asc')->get() as $cat)
      <div class="col">
        <a href="{{ route('frontend.categories.show',['category'=>$cat->id]) }}">
          <div class="course-one__single course-category-one__single color-1">
            
            <img src="{{$cat->getFirstMediaUrl('images')}}" width="80"/>
            <div class="course-one__content">
              <h2 class="course-one__title">{{ $cat->title }}</h2>
            </div>
          </div>
        </a>
      </div>
      @endforeach
    </div>
  </div>
</section>
@endsection
