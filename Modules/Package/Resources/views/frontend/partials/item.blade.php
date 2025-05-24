<div class="product-block">
  <a href="{{ route('frontend.packages.show',$package->id) }}" class="img-block">
    <img class="img-fluid" src="{{$package->getFirstMediaUrl('images')}}" alt="" />
  </a>
  <div class="content-block">
    <a class="pro-name" href="{{ route('frontend.packages.show',$package->id) }}">{{ $package->title }}</a>
    @if($package->is_free)
      <div class="price">{{ __('free package') }}</div>

      <a class="btn addto-cart theme-btn" href="{{ route('frontend.packages.subscribeForm',$package->id) }}">
        {{ __('Subscribe now') }}
      </a>
    @else
      <div class="form-group" style="margin-bottom: 0px">
          <select onchange="changeItemData(this)" style="height:36px;line-height: 26px;padding: 0rem 1rem;" class="select2_package form-control">

            <option value="">{{__('select Duration')}}</option>
            @foreach($package->prices as $priceItem)
              <option {{$loop->first ? 'selected' : ''}} value="{{$package->id}}" data-item="{{$priceItem}}">{{$priceItem->subscribe_duration_desc}}</option>
            @endforeach
          </select>
      </div>
      @php $packagePrice = $package->prices()->first(); @endphp
      <div class="price_data" style="display:{{$packagePrice ? 'block':'none'}};margin-top: 21px;">
        <div class="block">
          <h4 class="inner-title">{{__('Duration')}}: {{optional($packagePrice)->subscribe_duration_desc}}</h4>
        </div>
        <div class="the_price">{!! $packagePrice ? $packagePrice->active_price['price_html'] : '' !!}</div>

        <a class="btn addto-cart theme-btn" href="{{ $packagePrice ? route('frontend.packages.subscribeForm',$packagePrice->id) : '#' }}">
          {{ __('Subscribe now') }}
        </a>
      </div>
    @endif
  </div>
</div>
