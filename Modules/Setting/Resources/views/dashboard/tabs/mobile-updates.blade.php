
<div class="tab-pane fade" id="mobile-updates">
  {{--  tab for lang --}}
  <ul class="nav nav-tabs">
    @foreach (['ios','android'] as $code)
        <li class="@if($loop->first) active @endif">
            <a data-toggle="tab"
                href="#first_{{$code}}">{{$code}}</a>
        </li>
    @endforeach
  </ul>

  {{--  tab for content --}}
  <div class="tab-content">

    @foreach (['ios','android'] as $code)
        <div id="first_{{$code}}"
              class="tab-pane fade @if($loop->first) in active @endif">
              
          {!! field()->text("mobile_apps_updates[$code][version]", 'version',setting("mobile_apps_updates","$code.version")) !!}

          {!! field()->checkBox("mobile_apps_updates[$code][production_status]", 'production status',setting("mobile_apps_updates","$code.production_status") ? true : null,[
            setting("mobile_apps_updates","$code.production_status") ? "checked" : "" => ""
          ]) !!}

          {!! field()->checkBox("mobile_apps_updates[$code][force_update]", 'force update',setting("mobile_apps_updates","$code.force_update") ? true : null,[
            setting("mobile_apps_updates","$code.force_update") ? "checked" : "" => ""
          ]) !!}
        </div>
    @endforeach

  </div>
</div>