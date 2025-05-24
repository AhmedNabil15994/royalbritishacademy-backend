<div class="page-sidebar-wrapper">

  <div class="page-sidebar navbar-collapse collapse">
    <ul class="page-sidebar-menu  page-header-fixed" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">

      <li class="sidebar-toggler-wrapper hide">
        <div class="sidebar-toggler">
          <span></span>
        </div>
      </li>
      <li class="nav-item {{ active_menu('home') }}">
        <a href="{{ url(route('dashboard.home')) }}" class="nav-link nav-toggle">
          <i class="icon-home"></i>
          <span class="title">{{ __('apps::dashboard.index.title') }}</span>
          <span class="selected"></span>
        </a>
      </li>

      <li class="heading">
        <h3 class="uppercase">{{ __('apps::dashboard._layout.aside._tabs.control') }}</h3>
      </li>

      @can('show_roles')
      <li class="nav-item {{ active_menu('roles') }}">
        <a href="{{ url(route('dashboard.roles.index')) }}" class="nav-link nav-toggle">
          <i class="icon-briefcase"></i>
          <span class="title">{{ __('apps::dashboard._layout.aside.roles') }}</span>
          <span class="selected"></span>
        </a>
      </li>
      @endcan


      @can('show_admins')
      <li class="nav-item {{ active_menu('admins') }}">
        <a href="{{ url(route('dashboard.admins.index')) }}" class="nav-link nav-toggle">
          <i class="icon-users"></i>
          <span class="title">{{ __('apps::dashboard._layout.aside.admins') }}</span>
          <span class="selected"></span>
        </a>
      </li>
      @endcan
      @can('show_users')
      <li class="nav-item {{ active_menu('users') }}">
        <a href="{{ url(route('dashboard.users.index')) }}" class="nav-link nav-toggle">
          <i class="icon-users"></i>
          <span class="title">{{ __('apps::dashboard._layout.aside.users') }}</span>
          <span class="selected"></span>
        </a>
      </li>
      @endcan
      @can('show_trainers')
      <li class="nav-item {{ active_menu('trainers') }}">
        <a href="{{ url(route('dashboard.trainers.index')) }}" class="nav-link nav-toggle">
          <i class="icon-users"></i>
          <span class="title">{{ __('apps::dashboard._layout.aside.trainers') }}</span>
          <span class="selected"></span>
        </a>
      </li>
      @endcan
      
      @can('show_categories')
      <li class="nav-item  {{ active_menu('categories') }}">
        <a href="{{ url(route('dashboard.categories.index')) }}" class="nav-link nav-toggle">
          <i class="icon-settings"></i>
          <span class="title">{{ __('apps::dashboard._layout.aside.stages') }}</span>
        </a>
      </li>
      @endcan
      
      @can('show_materials')
      <li class="nav-item  {{ active_menu('materials') }}">
        <a href="{{ url(route('dashboard.materials.index')) }}" class="nav-link nav-toggle">
          <i class="icon-settings"></i>
          <span class="title">{{ __('apps::dashboard._layout.aside.materials') }}</span>
        </a>
      </li>
      @endcan



      @canany($coursesPermissions=['show_courses','show_lessons','show_lessoncontents','show_coursereviews'])
      <li class="nav-item open  {{active_slide_menu(['courses','lessons','lessoncontents','coursereviews'])}}">
        <a href="javascript:;" class="nav-link nav-toggle">
          <i class="icon-pointer"></i>
          <span class="title">{{ __('apps::dashboard._layout.aside._tabs.courses')}}</span>
          <span class="arrow {{active_slide_menu(['courses','lessons','lessoncontents','coursereviews'])}}"></span>
          <span class="selected"></span>
        </a>
        <ul class="sub-menu" style="display: block;">
          @can('show_courses')
          <li class="nav-item {{ active_menu('courses') }}">
            <a href="{{ route('dashboard.courses.index') }}" class="nav-link nav-toggle">
              <i class="fa fa-building"></i>
              <span class="title">{{ __('apps::dashboard._layout.aside.courses') }}</span>
              <span class="selected"></span>
            </a>
          </li>
          @endcan
          @can('show_lessoncontents')
          <li class="nav-item {{ active_menu('lessoncontents') }}">
            <a href="{{ route('dashboard.lessoncontents.index') }}" class="nav-link nav-toggle">
              <i class="fa fa-building"></i>
              <span class="title">{{ __('apps::dashboard._layout.aside.lesson_contents') }}</span>
              <span class="selected"></span>
            </a>
          </li>
          @endcan
         
        </ul>
      </li>
      @endcan

     
      @can('show_coupons')
      <li class="nav-item {{ active_menu('coupons') }}">
        <a href="{{ route('dashboard.coupons.index') }}" class="nav-link nav-toggle">
          <i class="fa fa-building"></i>
          <span class="title">{{ __('Coupons') }}</span>
          <span class="selected"></span>
        </a>
      </li>
      @endcan


     
      @can('show_orders')
      <li class="nav-item {{ active_menu('orders') }}">
        <a href="{{ route('dashboard.orders.index') }}" class="nav-link nav-toggle">
          <i class="fa fa-shopping-cart"></i>
          <span class="title">{{ __('Orders') }}</span>
          <span class="selected"></span>
        </a>
      </li>
      @endcan
      @can('show_orders_reports')
      <li class="nav-item {{ active_menu('reports') }}">
        <a href="{{ route('dashboard.orders.reports.index') }}" class="nav-link nav-toggle">
          <i class="fa fa-file"></i>
          <span class="title">{{ __('Orders Reports') }}</span>
          <span class="selected"></span>
        </a>
      </li>
      @endcan

      


      @canany(['show_countries','show_areas','show_cities','show_states'])
      <li class="nav-item  {{active_slide_menu(['countries','cities','states','areas'])}}">
        <a href="javascript:;" class="nav-link nav-toggle">
          <i class="icon-pointer"></i>
          <span class="title">{{ __('apps::dashboard._layout.aside.countries') }}</span>
          <span class="arrow {{active_slide_menu(['countries','governorates','cities','regions'])}}"></span>
          <span class="selected"></span>
        </a>
        <ul class="sub-menu">

          @can('show_countries')
          <li class="nav-item {{ active_menu('countries') }}">
            <a href="{{ url(route('dashboard.countries.index')) }}" class="nav-link nav-toggle">
              <i class="fa fa-building"></i>
              <span class="title">{{ __('apps::dashboard._layout.aside.countries') }}</span>
              <span class="selected"></span>
            </a>
          </li>
          @endcan

          @can('show_cities')
          <li class="nav-item {{ active_menu('cities') }}">
            <a href="{{ url(route('dashboard.cities.index')) }}" class="nav-link nav-toggle">
              <i class="fa fa-building"></i>
              <span class="title">{{ __('apps::dashboard._layout.aside.cities') }}</span>
              <span class="selected"></span>
            </a>
          </li>
          @endcan

          @can('show_states')
          <li class="nav-item {{ active_menu('states') }}">
            <a href="{{ url(route('dashboard.states.index')) }}" class="nav-link nav-toggle">
              <i class="fa fa-building"></i>
              <span class="title">{{ __('apps::dashboard._layout.aside.state') }}</span>
              <span class="selected"></span>
            </a>
          </li>
          @endcan
        </ul>
      </li>
      @endcanAny



      @canany(['show_pages','edit_settings','show_logs','show_telescope'])
      <li class="heading">
        <h3 class="uppercase">{{ __('apps::dashboard._layout.aside._tabs.other') }}</h3>
      </li>

      @can('show_pages')
      <li class="nav-item {{ active_menu('pages') }}">
        <a href="{{ url(route('dashboard.pages.index')) }}" class="nav-link nav-toggle">
          <i class="icon-docs"></i>
          <span class="title">{{ __('apps::dashboard._layout.aside.pages') }}</span>
          <span class="selected"></span>
        </a>
      </li>
      @endcan
      @can('edit_settings')
      <li class="nav-item {{ active_menu('setting') }}">
        <a href="{{ url(route('dashboard.setting.index')) }}" class="nav-link nav-toggle">
          <i class="icon-settings"></i>
          <span class="title">{{ __('apps::dashboard._layout.aside.setting') }}</span>
          <span class="selected"></span>
        </a>
      </li>
      @endcan
      @can('show_logs')
      <li class="nav-item {{ active_menu('logs-s') }}">
        <a href="{{ url(route('dashboard.logs-s.index')) }}" class="nav-link nav-toggle">
          <i class="icon-folder"></i>
          <span class="title">{{ __('apps::dashboard._layout.aside.logs') }}</span>
          <span class="selected"></span>
        </a>
      </li>
      @endcan

      @can('show_telescope')
      <li class="nav-item {{ active_menu('telescope') }}">
        <a href="{{ url(route('telescope')) }}" class="nav-link nav-toggle">
          <i class="icon-settings"></i>
          <span class="title">{{ __('apps::dashboard._layout.aside.telescope') }}</span>
          <span class="selected"></span>
        </a>
      </li>
      @endcan
      @endcanAny
    </ul>
  </div>

</div>
