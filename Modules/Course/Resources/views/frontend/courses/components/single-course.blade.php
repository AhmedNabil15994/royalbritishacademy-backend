<div class="product-grid">
  <div class="product-image img-block d-flex align-items-center">
    @if($course->is_new)
    <div class="ribbon"><span class="primary">{{__('apps::frontend.products.new')}}</span></div>
    @endif
    <a href="{{route('frontend.courses.show', $course->slug)}}">
      <img class="pic-1" src="{{asset($course->image)}}">
    </a>
    <ul class="social">
      <li><a href="{{route('frontend.courses.show', $course->slug)}}" data-tip="Product Details"><i class="ti ti-eye"></i></a></li>
    </ul>
  </div>
  <div class="product-content">
    <h3 class="title">
      <a href="{{route('frontend.courses.show', $course->slug)}}">{{$course->title}}</a>
    </h3>

    @if (!is_null($course->trainer))
    <a class="" href="{{ route('frontend.trainers.show', $course->trainer->id) }}">{{ $course->trainer->name }}</a>
    @endif

    <span class="course-users"><i class="fa fa-users"></i>
      {{
      $course->order_course_count<10 ?$course->id*1:$course->order_course_count}}
    </span>
    <br>
    <span class="price">
      {{ $course->price }}
    </span>
    <br>
    <div class="star-rating" data-rating="{{ $course->stars??5}}"></div>
    <div>
      @if($course->is_subscribed==0)
      <a href="{{route('frontend.cart.add',['course',$course->slug])}}" style="margin: 10px 0px;" class="btnGeneralAddToCart btn main-custom-btn">
        {{ __('Add To Cart') }}
      </a>
      @else
      <a href="{{route('frontend.courses.show',['slug'=>$course->slug])}}" style="margin: 10px 0px;" class="btnGeneralAddToCart btn main-custom-btn">
        {{ __('you are subscriped') }}
      </a>
      @endif
    </div>
  </div>
</div>
