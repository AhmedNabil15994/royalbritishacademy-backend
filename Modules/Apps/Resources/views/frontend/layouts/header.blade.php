<div class="page-wrapper">
  <div class="topbar-one">
    <div class="container">
      <div class="topbar-one__right">
        @auth
        <a href="{{ route('frontend.profile.index') }}">{{ __('My Account') }}</a>
        @else
        {{-- <a href="{{ route('frontend.auth.register') }}">{{ __('Join us') }}</a> --}}
        <a href="{{ route('frontend.auth.login') }}">{{ __('Login') }}</a>
        @endauth
        @include('apps::frontend.layouts.lang-bar')
      </div>
    </div>
  </div>
  <header class="site-header site-header__header-one">
    <nav class="navbar navbar-expand-lg navbar-light header-navigation stricky">
      <div class="container clearfix">
        <div class="logo-box clearfix">
          <a class="navbar-brand" href="{{ route('frontend.home') }}">
            <img src="{{setting('logo')?asset(setting('logo')): asset('frontend/assets/images/mlogo-dark.png') }}" class="main-logo" alt="Awesome Image" />
          </a>
          <button class="menu-toggler" data-target=".main-navigation">
            <span class="sama-icon-menu"></span>
          </button>
        </div>
        <div class="main-navigation">
          <ul class="navigation-box">
            <li>
              <a class="active" href="{{ route('frontend.home') }}">{{ __('Home') }}</a>
            </li>
            @foreach($mainCategories as $category)
            <li>
              <a href="{{ route('frontend.categories.show',['category'=>$category->id]) }}">{{ $category->title }}</a>
            </li>
            @endforeach
          </ul>
        </div>
        <div class="right-side-box">
          <a class="header__search-btn search-popup__toggler" href="#"><i class="sama-icon-magnifying-glass"></i>
          </a>
          <a class="header__search-btn" href="{{ route('frontend.cart.index') }}">
            @php $cartCount = count(Cart::getContent()); @endphp
            <i class="fa fa-shopping-bag">
              @if ($cartCount)
                  <span>{{$cartCount}}</span>
              @endif
            </i>
          </a>
        </div>
      </div>
    </nav>
  </header>
