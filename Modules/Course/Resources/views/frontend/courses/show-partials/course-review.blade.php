<div class="description-box mb-30 reviews">
  <div class="d-flex align-items-center justify-content-between mb-30">
    @if($course->activeCourseReviews()->count()>0)
    <h3>{{ __('Reviews') }}</h3>
    @endif
    @if ($course->is_subscribed > 0&&!$course->isReviewed())
    <button class="btn btn main-custom-btn feedback-btn" data-toggle="modal" data-target="#exampleModal">{{ __('Leave Feedback') }}</button>
    @endif
  </div>


  @foreach($course->activeCourseReviews as $key => $courseReview)
  <div class="media">
    <div class="media-left">
      <a href="#" class="text-white">
        AM
      </a>
    </div>
    <div class="media-body">
      <h4 class="media-heading">{{$courseReview->user->nameWithMembership() }}</h4>
      <div class="star-rating" data-rating="{{ $courseReview->stars }}"></div>
      <p>{!! $courseReview->desc !!}</p>
    </div>
  </div>

  @endforeach
</div>

<div class="modal fade review-modal" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <h2>{{ __('Would You like to leave a review?') }}</h2>
        {!! Form::open([
        'url'=> route('frontend.courses.review',$course->id),
        'id'=>'form',
        'role'=>'form',
        'method'=>'POST',
        'class'=>'review-form',
        'files' => true
        ])!!}

        @foreach($reviewQuestions as $key => $question)
        <div class="form-group">
          <input type="hidden" name="answers[{{ $question->id }}][review_question_id]" value="{{ $question->id }}">
          <label>{{ $loop->iteration }}- {{ $question->title }}</label>
          <div class="custom-control custom-radio">
            <input type="radio" id="question_yes_{{ $question->id }}" name="answers[{{ $question->id }}][answer]" class="" value="1">
            <label class="" for="question_yes_{{ $question->id }}">{{ __('Yes') }}</label>
          </div>
          <div class="custom-control custom-radio">
            <input type="radio" id="question_no_{{ $question->id }}" name="answers[{{ $question->id }}][answer]" class="" value="0">
            <label class="" for="question_no_{{ $question->id }}">{{ __('No') }}</label>
          </div>
        </div>
        @endforeach
        <div class="form-group">
          <label>{{ __('We welcome your suggestions here') }}</label>
          <textarea name="desc" class="form-control"></textarea>
        </div>
        <div class="form-group">
          <label>{{ __('Select Rating') }}</label>
          <div class="rate">
            <input type="radio" id="star10" name="stars" value="5" />
            <label for="star10" title="text"></label>
            <input type="radio" id="star20" name="stars" value="4" />
            <label for="star20" title="text"></label>
            <input type="radio" id="star30" name="stars" value="3" />
            <label for="star30" title="text"></label>
            <input type="radio" id="star40" name="stars" value="2" />
            <label for="star40" title="text"></label>
            <input type="radio" id="star50" name="stars" value="1" />
            <label for="star50" title="text"></label>
          </div>
        </div>
        <div class="form-group">
          <button type="submit" id="submit" class="btn btn main-custom-btn">{{ __('submit') }}</button>
          <button type="submit" class="btn btn-light cancel-btn" data-dismiss="modal">{{ __('Cancel') }}</button>
        </div>
        </form>
      </div>
    </div>
  </div>
</div>
@push('scripts')
<script>
  function resetForm(){}
  function afterSuccess(){
    $('.feedback-btn').hide()
  }
</script>
@endpush
