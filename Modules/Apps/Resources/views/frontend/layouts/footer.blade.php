<footer class="site-footer">
  <div class="site-footer__upper">
    <div class="container">
      <div class="row">
        <div class="col-xl-3 col-lg-6 col-sm-12">
          <div class="footer-widget footer-widget__contact">
            <h2 class="footer-widget__title">{{ __('Educational Stages') }}</h2>
            <ul class="list-unstyled footer-widget__link-list">
              @foreach($mainCategories as $category)
              <li><a href="{{ route('frontend.categories.show',['category'=>$category]) }}">{{ $category->title }}</a></li>
              @endforeach
            </ul>
          </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-sm-12">
          <div class="footer-widget footer-widget__link">
            <h2 class="footer-widget__title">{{ __('Other links') }}</h2>
            <div class="footer-widget__link-wrap">
              <ul class="list-unstyled footer-widget__link-list">
                <li><a href="{{ route('frontend.home') }}">{{ __('Home') }}</a></li>
                @if($pages['terms'])
                <li><a href="{{ route('frontend.pages.show',['page'=>$pages['terms']['id']]) }}">{{ __('Terms of use') }}</a></li>
                @endif
                @if($pages['privacyPolicy'])
                <li><a href="{{ route('frontend.pages.show',['page'=>$pages['privacyPolicy']['id']]) }}">{{ __('Privacy Policy') }}</a></li>
                @endif
              </ul>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-sm-12">
          <div class="footer-widget footer-widget__gallery">
            <h2 class="footer-widget__title">{{ __('Download the app') }}</h2>
            <ul class="list-unstyled footer-widget__gallery-list">
              <li><a href="#"><img src="{{ asset('frontend') }}/assets/images/app.png" alt=""></a></li>
            </ul>
          </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-sm-12">
          <div class="footer-widget footer-widget__about">
            <h2 class="footer-widget__title">{{ setting('app_name',locale()) }}</h2>
            <p class="footer-widget__text">{!! $pages['aboutUs']['description'] ?? '' !!}</p>
            {{-- <div class="footer-widget__btn-block">
              <a href="{{ route('frontend.auth.register') }}" class="thm-btn">{{ __('Join us now') }}</a>
            </div> --}}
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="site-footer__bottom">
    <div class="container">
      <p class="site-footer__copy">&copy; All rights reserved to Royal British Academy    e-learning. Designed and programmed by <a href="https://www.tocaan.com/">Tocaan
          Company</a>
      </p>
      <div class="site-footer__social">
        <a href="#" data-target="html" class="scroll-to-target site-footer__scroll-top"><i class="sama-icon-top-arrow"></i></a>
        @if(setting('social','twitter'))
        <a href="{{ setting('social','twitter') }}"><i class="fab fa-twitter"></i></a>
        @endif
        @if(setting('social','facebook'))
        <a href="{{ setting('social','facebook') }}"><i class="fab fa-facebook-square"></i></a>
        @endif

        @if(setting('social','pinterest'))
        <a href="{{ setting('social','pinterest') }}"><i class="fab fa-pinterest-p"></i></a>
        @endif

        @if(setting('social','instagram'))
        <a href="{{ setting('social','instagram') }}"><i class="fab fa-instagram"></i></a>
        @endif
      </div>
    </div>
  </div>
</footer>

</div>

<div class="search-popup">
  <div class="search-popup__overlay custom-cursor__overlay">
    <div class="cursor"></div>
    <div class="cursor-follower"></div>
  </div>
  <div class="search-popup__inner">
    <form action="#" class="search-popup__form">
      <input type="text" name="search" placeholder="Type here to search...">
      <button type="submit"><i class="sama-icon-magnifying-glass"></i></button>
    </form>
  </div>
</div>
