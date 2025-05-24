@extends('apps::frontend.layouts.app')
@section('title', $course->title)
@section('content')
<div class="page-wrapper course-details-new">
  <div class="topbar-one course-d">
    <div class="container">
      <div class="topbar-one__right ">
        <ul class="navbar-nav">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="{{ route('frontend.courses.show',
            ['slug'=>$course->slug,'semester_id'=>$currentSemester->id]) }}" role="button" data-toggle="dropdown" aria-expanded="false">
              {{ $currentSemester->title }}
            </a>
            <div class="dropdown-menu">
              @foreach($semesters as $key => $semester)
              <a class="dropdown-item" href="{{ route('frontend.courses.show',['slug'=>$course->slug,'semester_id'=>$semester->id]) }}">
                {{ $semester->title}}
              </a>
              @endforeach
            </div>
          </li>
        </ul>
        <div class="links__topbar">

          @if(!$course->current_user_has_access)
          <a href="{{ route('frontend.cart.add',['id'=>$course->id,'type'=>'course']) }}" class="thm-btn banner-one__btn">{{ __('Add to Cart') }}</a>
          @endif
          
          @include('apps::frontend.layouts.lang-bar')
        </div>
      </div>
      <div class="logo-box clearfix">
        <a class="navbar-brand" href="{{ route('frontend.home') }}">
          <img src="{{setting('logo')?asset(setting('logo')): asset('frontend/assets/images/mlogo-dark.png') }}" class="main-logo" alt="Awesome Image" />
        </a>
      </div>
    </div>
  </div>

  <section class="course-details details-parts bg-color-dark">
    <div class="container-fluid">
      <div class="playlists">
        <div class="row basic">
          <div class="col-lg-3">
            <div class="playlists-part">
              <div class="pill-header">
                <div class="card">
                  <h5 class="mb-0">
                    <div class="course-details__meta-icon file-icon"> <i class="fas fa-folder"></i></div>
                    {{ $course->title }}
                  </h5>
                  @if(!$course->current_user_has_access)
                  <a href="{{ route('frontend.cart.add',['id'=>$course->id,'type'=>'course']) }}" class="thm-btn banner-one__btn">{{ __('Add to Cart') }}</a>
                  @endif
                </div>
              </div>
              <div id="accordion" class="course-details__curriculum-list list-unstyled">
                @php $firstVideoId = null;@endphp
                @php $lessons = $course->lessons()->active()->semesterId($currentSemester->id)->orderBy('order','asc')->get();@endphp
                @foreach($lessons as $key => $lesson)
                  @if($loop->first)
                    @php $firstVideoId = $lesson->lessonContents()->active()->orderBy('order','asc')->first()?->id;@endphp
                  @endif
                  <div class="card">
                    <div class="card-header" id="heading-{{ $lesson->id }}">
                      <h5 class="mb-0">
                        <a role="button" data-toggle="collapse" href="#collapse-{{ $lesson->id }}" aria-controls="collapse-{{ $lesson->id }}">
                          <div class="course-details__meta-icon">
                            <i class="far fa-flag"></i>
                          </div>
                          {{ $lesson->title }}
                        </a>
                      </h5>
                    </div>
                    <div id="collapse-{{ $lesson->id }}" class="collapse tab show" data-parent="#accordion" aria-labelledby="heading-{{ $lesson->id }}">
                      <div class="card-body">
                        <ul class="course-details__curriculum-list list-unstyled">
                          @foreach($lesson->lessonContents()->active()->orderBy('order','asc')->get() as $lessonContent)
                          @include('course::frontend.courses.lesson-content-type.'.$lessonContent->type,['parent'=>$loop->parent->iteration,'course' => $course])
                          @endforeach
                        </ul>
                      </div>
                    </div>
                  </div>
                @endforeach
              </div>
            </div>
          </div>
          <div class="col-lg-9">
            <div class="course-details__content">
              @if($course->current_user_has_access)
                @foreach($course->lessons()->active()->semesterId($currentSemester->id)->orderBy('order','asc')->get() as $key => $lesson)
                  @foreach($lesson->lessonContents()->active()->orderBy('order','asc')->get() as $lessonContent)
                    <div class="course-one__vide video-select tabcontent" id="vid-{{ $lessonContent->id }}">
                      <iframe src="{{ $lessonContent->video_link }}"></iframe>
                    </div>
                  @endforeach
                @endforeach
              @else
                <div class="course-one__vide video-select tabcontent" id="vid-{{ $firstVideoId }}">
                  <iframe src="{{ $course->intro_video }}"></iframe>
                </div>
              @endif
              <ul class="course-details__tab-navs list-unstyled nav nav-tabs" role="tablist">
                <li>
                  <a class="active" role="tab" data-toggle="tab" href="#overview-1">{{ __('Course summary') }}</a>
                </li>
                {{-- <li>
                  <a role="tab" data-toggle="tab" href="#q-a">{{ __('Q & A') }}</a>
                </li> --}}
              </ul>
              <div class="tab-content course-details__tab-content ">
                <div class="tab-pane show active  animated fadeInUp" role="tabpanel" id="overview-1">
                  <p class="course-details__tab-text">
                    {!! $course->description !!}
                  </p>
                </div>
                {{-- <div class="tab-pane animated fadeInUp" role="tabpanel" id="q-a">
                  <form action="#" class="course-details__comment-form">
                    <div class="row">
                      <div class="col-lg-12">
                        <textarea placeholder="{{ __('Write a question') }}"></textarea>
                        <button type="submit" class="thm-btn course-details__comment-form-btn">{{ __('send question') }}</button>
                      </div>
                    </div>
                  </form>

                  <div class="course-details__comment">
                    <h3> {{ __('questions in this course') }}</h3>
                    <div class="answers-list">
                      <div class="course-details__comment-single">
                        <div class="course-details__comment-top">
                          <span class="course-details__meta-icon">
                            <i class="far fa-user-circle"></i>
                          </span>
                          <div class="course-details__comment-right">
                            <h2 class="course-details__comment-name">Mohamed Albrolosy</h2>
                            <div class="course-details__comment-meta">
                              <p class="course-details__comment-date">11/6/2022</p>
                            </div>
                          </div>
                        </div>
                        <p class="course-details__comment-text">
                          How can we find a solution to this issue?
                        </p>
                      </div>
                      <div class="accordion">
                        <div class="accordion-group reply">
                          <div class="accordion-heading area">
                            <a class="accordion-toggle" data-toggle="collapse" href="#reply">
                              <div class="course-details__meta-icon">
                                <i class="far fa-flag"></i>
                              </div>
                              Add a reply
                            </a>
                            <a class="accordion-toggle" data-toggle="collapse" href="#answers">
                              <div class="course-details__meta-icon">
                                <i class="far fa-comment"></i>
                              </div>
                              replies
                            </a>
                          </div>

                          <div class="accordion-body collapse " id="reply">
                            <div class="accordion-inner">
                              <form action="#" class="course-details__comment-form">
                                <div class="row">
                                  <div class="col-lg-12">
                                    <textarea placeholder="Write your Reply"></textarea>
                                    <button type="submit" class="thm-btn course-details__comment-form-btn">
                                      Send Reply</button>
                                  </div>
                                </div>
                              </form>
                            </div>
                          </div>
                          <div class="accordion-body collapse show" id="answers">
                            <div class="accordion-inner">
                              <div class="course-details__comment-single answers__style">
                                <div class="course-details__comment-top">
                                  <span class="course-details__meta-icon">
                                    <i class="far fa-user-circle"></i>
                                  </span>
                                  <div class="course-details__comment-right">
                                    <h2 class="course-details__comment-name">Ali </h2>
                                    <div class="course-details__comment-meta">
                                      <p class="course-details__comment-date">11/6/2022</p>
                                    </div>
                                  </div>
                                </div>
                                <p class="course-details__comment-text">
                                  Evidence of complex mathematics does not appear until around 3000 BC, when the Babylonians and Egyptians began using
                                  arithmetic, algebra, and geometry for taxation and other financial calculations, for building and construction, and for
                                  astronomy. The oldest mathematical texts are from Mesopotamia and Egypt
                                </p>
                              </div>
                              <div class="course-details__comment-single answers__style">
                                <div class="course-details__comment-top">
                                  <span class="course-details__meta-icon">
                                    <i class="far fa-user-circle"></i>
                                  </span>
                                  <div class="course-details__comment-right">
                                    <h2 class="course-details__comment-name">Saed </h2>
                                    <div class="course-details__comment-meta">
                                      <p class="course-details__comment-date">11/6/2022</p>
                                    </div>
                                  </div>
                                </div>
                                <p class="course-details__comment-text">
                                  Evidence of complex mathematics does not appear until around 3000 BC, when the Babylonians and Egyptians began using
                                  arithmetic, algebra, and geometry for taxation and other financial calculations, for building and construction, and for
                                  astronomy. The oldest mathematical texts are from Mesopotamia and Egypt
                                </p>
                              </div>
                              <div class="course-details__comment-single answers__style">
                                <div class="course-details__comment-top">
                                  <span class="course-details__meta-icon">
                                    <i class="far fa-user-circle"></i>
                                  </span>
                                  <div class="course-details__comment-right">
                                    <h2 class="course-details__comment-name">Ayman </h2>
                                    <div class="course-details__comment-meta">
                                      <p class="course-details__comment-date">11/6/2022</p>
                                    </div>
                                  </div>
                                </div>
                                <p class="course-details__comment-text">
                                  Evidence of complex mathematics does not appear until around 3000 BC, when the Babylonians and Egyptians began using
                                  arithmetic, algebra, and geometry for taxation and other financial calculations, for building and construction, and for
                                  astronomy. The oldest mathematical texts are from Mesopotamia and Egypt
                                </p>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div><!-- /accordion -->
                    </div>

                    <div class="answers-list">
                      <div class="course-details__comment-single">
                        <div class="course-details__comment-top">
                          <span class="course-details__meta-icon">
                            <i class="far fa-user-circle"></i>
                          </span>
                          <div class="course-details__comment-right">
                            <h2 class="course-details__comment-name">Mohamed Albrolosy</h2>
                            <div class="course-details__comment-meta">
                              <p class="course-details__comment-date">11/6/2022</p>
                            </div>
                          </div>
                        </div>
                        <p class="course-details__comment-text">
                          How can we find a solution to this issue?
                        </p>
                      </div>
                      <div class="accordion">
                        <div class="accordion-group reply">
                          <div class="accordion-heading area">
                            <a class="accordion-toggle" data-toggle="collapse" href="#reply-2">
                              <div class="course-details__meta-icon">
                                <i class="far fa-flag"></i>
                              </div>
                              Add a reply
                            </a>
                            <a class="accordion-toggle" data-toggle="collapse" href="#answers-2">
                              <div class="course-details__meta-icon">
                                <i class="far fa-comment"></i>
                              </div>
                              replies
                            </a>
                          </div>

                          <div class="accordion-body collapse" id="reply-2">
                            <div class="accordion-inner">
                              <form action="#" class="course-details__comment-form">
                                <div class="row">
                                  <div class="col-lg-12">
                                    <textarea placeholder="اكتب ردك"></textarea>
                                    <button type="submit" class="thm-btn course-details__comment-form-btn">
                                      ارسال الرد</button>
                                  </div>
                                </div>
                              </form>
                            </div>
                          </div>
                          <div class="accordion-body collapse " id="answers-2">
                            <div class="accordion-inner">
                              <div class="course-details__comment-single answers__style">
                                <div class="course-details__comment-top">
                                  <span class="course-details__meta-icon">
                                    <i class="far fa-user-circle"></i>
                                  </span>
                                  <div class="course-details__comment-right">
                                    <h2 class="course-details__comment-name">Ali </h2>
                                    <div class="course-details__comment-meta">
                                      <p class="course-details__comment-date">11/6/2022</p>
                                    </div>
                                  </div>
                                </div>
                                <p class="course-details__comment-text">
                                  Evidence of complex mathematics does not appear until around 3000 BC, when the Babylonians and Egyptians began using
                                  arithmetic, algebra, and geometry for taxation and other financial calculations, for building and construction, and for
                                  astronomy. The oldest mathematical texts are from Mesopotamia and Egypt
                                </p>
                              </div>
                              <div class="course-details__comment-single answers__style">
                                <div class="course-details__comment-top">
                                  <span class="course-details__meta-icon">
                                    <i class="far fa-user-circle"></i>
                                  </span>
                                  <div class="course-details__comment-right">
                                    <h2 class="course-details__comment-name">Saed </h2>
                                    <div class="course-details__comment-meta">
                                      <p class="course-details__comment-date">11/6/2022</p>
                                    </div>
                                  </div>
                                </div>
                                <p class="course-details__comment-text">
                                  Evidence of complex mathematics does not appear until around 3000 BC, when the Babylonians and Egyptians began using
                                  arithmetic, algebra, and geometry for taxation and other financial calculations, for building and construction, and for
                                  astronomy. The oldest mathematical texts are from Mesopotamia and Egypt
                                </p>
                              </div>
                              <div class="course-details__comment-single answers__style">
                                <div class="course-details__comment-top">
                                  <span class="course-details__meta-icon">
                                    <i class="far fa-user-circle"></i>
                                  </span>
                                  <div class="course-details__comment-right">
                                    <h2 class="course-details__comment-name">Ayman </h2>
                                    <div class="course-details__comment-meta">
                                      <p class="course-details__comment-date">11/6/2022</p>
                                    </div>
                                  </div>
                                </div>
                                <p class="course-details__comment-text">
                                  Evidence of complex mathematics does not appear until around 3000 BC, when the Babylonians and Egyptians began using
                                  arithmetic, algebra, and geometry for taxation and other financial calculations, for building and construction, and for
                                  astronomy. The oldest mathematical texts are from Mesopotamia and Egypt
                                </p>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div><!-- /accordion -->
                    </div>
                    <div class="post-pagination">
                      <a class="active" href="#">1</a>
                      <a href="#">2</a>
                      <a href="#">3</a>
                      <a href="#">4</a>
                    </div>
                  </div>
                </div> --}}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>


  @endsection
