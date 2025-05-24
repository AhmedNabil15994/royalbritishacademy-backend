
<a href="#">
  <div class="course-one__single">
    <div class="course-one__image">
      <img src="{{ $note->image }}" alt="{{ $note->title }}">
    </div>
    <div class="course-one__content">
      <div class="course-one__category"> {{ $note->category?->title }} </div>
      <h2 class="course-one__title title-name">{{ $note->title }}</h2>
      <p>{{ __('Includes :notes_count notes',['notes_count'=> count($note->getMedia('pdf'))]) }} </p>
      @if($note->is_free)
          <a class="course-one__link" href="{{$note->getFirstMediaUrl('pdf')}}">@lang("Show")</a>
      @else
        <a href="{{ route('frontend.cart.add',['id'=>$note->id,'type'=>'note']) }}" class="course-one__link">{{ __('Add To Cart') }}</a>
      @endif
    </div>
  </div>
</a>