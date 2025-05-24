@extends('apps::frontend.layouts.app')
@section( 'title',__('packages'))
@section( 'content')
<div class="inner-page">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="products-container">
          <div class="row">
            @foreach($packages as $key => $package)
            <div class="col-md-4 col-6">
              @include('package::frontend.partials.item')
            </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
