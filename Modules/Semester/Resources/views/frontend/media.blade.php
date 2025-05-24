@extends('apps::frontend.layouts.app')
@section('title', $semester->translate(locale())->title)
@section('content')

<section class="page-head align-items-center text-center d-flex">
    <div class="container">
        <h1>{{ $semester->translate(locale())->title }}</h1>
        <ul class="mt-20">
            <li>
                <a href="{{ url(route('frontend.home')) }}">
                    <i class="ti-home"></i> {{ __('apps::frontend.navbar.home') }} /
                </a>
            </li>
            <li>
                <a href="{{ url(route('frontend.semesters.media_center')) }}">
                    {{ __('semester::frontend.media_center.title') }} /
                </a>
            </li>
            <li class="active">{{ $semester->translate(locale())->title }}</li>
        </ul>
    </div>
</section>

<div class="inner-page">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="semester-details">
                    <h1>{{ $semester->translate(locale())->title }}</h1>
                    <div class="semester-author">
                        <div class="row">
                            <div class="col-12 col-md-7">
                                <div class="media align-items-center">
                                    <div class="author-avatar">
                                        <img class="img-fluid rounded-circle" src="{{ url(setting('favicon')) }}" alt="Author">
                                    </div>
                                    <div class="media-body">
                                        <span class="d-block text-muted post-date">
                                            {{ date('M,d Y' , strtotime($semester->created_at)) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <img class="img-fluid" src="{{ url($semester->image) }}" alt="IMG">
                    <p>
                        {!! $semester->translate(locale())->description !!}
                    </p>
                </div>

                {{-- <div class="post-comments semester-author semester-written-by">
                    <h5>2 {{ __('semester::frontend.index.comments') }}</h5>
                    <div class="comments-replies border-bottom pb-6 mb-6">
                        <div class="comment-box">
                            <div class="media align-items-center">
                                <div class="comment-avatar">
                                    <img class="img-fluid rounded-circle" src="/frontend/en/images/semester/author-3.jpg" alt="Image Description">
                                </div>
                                <div class="media-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span>Dave Austin</span>
                                        <small class="text-muted">1 day ago</small>
                                    </div>
                                </div>
                            </div>
                            <p>As a Special Education teacher this resonates so well with me. Fighting with gen ed teachers to flatten for the students with
                                learning disabilities. It also confirms some things for me in my writing.</p>
                        </div>
                    </div>
                    <div class="comments-replies border-bottom pb-6 mb-6">
                        <div class="comment-box">
                            <div class="media align-items-center">
                                <div class="comment-avatar">
                                    <img class="img-fluid rounded-circle" src="/frontend/en/images/semester/author-3.jpg" alt="Image Description">
                                </div>
                                <div class="media-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span>Dave Austin</span>
                                        <small class="text-muted">1 day ago</small>
                                    </div>
                                </div>
                            </div>
                            <p>As a Special Education teacher this resonates so well with me. Fighting with gen ed teachers to flatten for the students with
                                learning disabilities. It also confirms some things for me in my writing.</p>
                        </div>
                    </div>
                    <div class="post-comment">
                        <h5>Post a comment</h5>
                        <form class="contact-form">
                            <input type="text" class="form-control mb-15" placeholder="You Name" />
                            <input type="email" class="form-control mb-15" placeholder="You Email" />
                            <textarea class="form-control mb-20" placeholder="Your Comment"></textarea>
                            <button class="btn theme-btn"><span>Post a comment</span></button>
                        </form>
                    </div>
                </div> --}}
            </div>

            {{-- <div class="col-md-4 semester-side-container">
                <div class="close-side"><i class="ti-close"></i></div>
                <div class="semester-side">
                    <form class="widget-search mb-20">
                        <div class="input-with-icon">
                            <i class="ti-search"></i>
                            <input type="text" placeholder="Trainer name" />
                        </div>
                    </form>
                    <div class="widget">
                        <h3 class="widget-title">Useful Links</h3>
                        <ul class="list-group list-group-flush">
                            <li>
                                <a class="list-group-item d-flex align-items-center" href="#">
                                    All
                                    <span class="badge badge-pill ml-2">30+</span>
                                    <small class="fas fa-angle-right ml-auto"></small>
                                </a>
                            </li>
                            <li>
                                <a class="list-group-item d-flex align-items-center" href="#">
                                    Top rated
                                    <small class="fas fa-angle-right ml-auto"></small>
                                </a>
                            </li>
                            <li>
                                <a class="list-group-item d-flex align-items-center" href="#">
                                    Featured
                                    <small class="fas fa-angle-right ml-auto"></small>
                                </a>
                            </li>
                            <li>
                                <a class="list-group-item d-flex align-items-center" href="#">
                                    Daily news
                                    <span class="badge bg-soft-secondary badge-pill ml-2">18</span>
                                    <small class="fas fa-angle-right ml-auto"></small>
                                </a>
                            </li>
                            <li>
                                <a class="list-group-item d-flex align-items-center" href="#">
                                    New
                                    <small class="fas fa-angle-right ml-auto"></small>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="widget">
                        <h3 class="widget-title">Related Stories</h3>
                        <article>
                            <div class="row justify-content-between">
                                <div class="col-7 pr-0">
                                    <a class="d-inline-block text-muted text-uppercase" href="#">Learning</a>
                                    <h4 class="mb-0">
                                        <a href="index.php?page=semester-post">Enjoy $1,000 worth with Front for Business</a>
                                    </h4>
                                </div>

                                <div class="col-5">
                                    <img class="img-fluid" src="/frontend/en/images/semester/img-1.jpg" alt="Image Description">
                                </div>
                            </div>
                        </article>
                        <article>
                            <div class="row justify-content-between">
                                <div class="col-7 pr-0">
                                    <a class="d-inline-block text-muted text-uppercase" href="#">Meditation</a>
                                    <h4 class="mb-0">
                                        <a href="index.php?page=semester-post">Enjoy $1,000 worth with Front for Business</a>
                                    </h4>
                                </div>

                                <div class="col-5">
                                    <img class="img-fluid" src="/frontend/en/images/semester/img-2.jpg" alt="Image Description">
                                </div>
                            </div>
                        </article>
                        <article>
                            <div class="row justify-content-between">
                                <div class="col-7 pr-0">
                                    <a class="d-inline-block text-muted text-uppercase" href="#">Yoga</a>
                                    <h4 class="mb-0">
                                        <a href="index.php?page=semester-post">Enjoy $1,000 worth with Front for Business</a>
                                    </h4>
                                </div>

                                <div class="col-5">
                                    <img class="img-fluid" src="/frontend/en/images/semester/img-3.jpg" alt="Image Description">
                                </div>
                            </div>
                        </article>
                    </div>

                    <div class="widget">
                        <h3 class="widget-title">Popular Tags</h3>
                        <div class="post-tags">
                            <a class="btn" href="#">Areil</a>
                            <a class="btn" href="#">Ecommerce</a>
                            <a class="btn" href="#">Application</a>
                            <a class="btn" href="#">Semester</a>
                            <a class="btn" href="#">Startup</a>
                            <a class="btn" href="#">Website</a>
                            <a class="btn" href="#">Free</a>
                            <a class="btn" href="#">Bootstrap</a>
                            <a class="btn" href="#">Developer</a>
                            <a class="btn" href="#">Code</a>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>
        {{-- <div class="res-semester-side align-items-center mt-20">
            <span><i class="ti-layout-list-thumb"></i> Semester Options</span>
            <i class="ti-angle-double-right"></i>
        </div> --}}
    </div>
</div>


@stop
