@push('styles')
<style>
  .inline-selector {
    display: inline !important;
    padding: 0px 12px;
    margin: 5px 18px;
  }

  .input-xsmall {
    width: 88px !important;
    margin: 4px 9px;
  }

  .notee {
    padding: 20px 50px;
  }

  .price_item {
    padding: 5px;
    border: 1px solid #d5d5d5;
    margin-bottom: 10px;
  }

  .inline-selector-label {
    margin: 0px 3px;
  }

  .inline-selector-label-actions {
    margin: 0px 28px;
  }

  .inline-selector-label-actions i {
    margin: 0px 6px;
    cursor: pointer;
  }

  .inline-selector-label-actions .fa-plus {
    color: rgb(63, 198, 211);
  }

  .inline-selector-label-actions .fa-remove {
    color: rgb(244, 67, 54);
  }

  .inline-selector-label-actions .active {
    cursor: pointer;
  }

  .inline-selector-label-actions .deactive {
    color: rgb(213 213 213);
    cursor: not-allowed;
  }

  .input-larg {
    width: -webkit-fill-available;
  }

</style>
@endpush
<div class="portlet light bordered" style="    border: 1px solid #e7ecf1!important">
  <div class="portlet-title">
    <div class="caption font-red-sunglo">
      <span class="caption-subject bold uppercase">{{ __('package::dashboard.packages.form.tabs.prices') }}</span>
    </div>
  </div>
  <div class="portlet-body">
    <div class="row" style="margin: 0px;">
      <div class="col-lg-12">
        <div class="form-group">
          <input step="0.01" type="number" step=".01" class="form-control input-small inline-selector" v-model="price" placeholder="price" />
          <input step="0.00" type="number" step=".01" class="form-control input-small inline-selector" v-model="offer_percentage"
            placeholder="Offer Percentage" />
          <input type="date" class="form-control input-small inline-selector" v-model="start_offer_date" placeholder="Offer start date" />
          <input type="date" class="form-control input-small inline-selector" v-model="end_offer_date" placeholder="Offer end date" />
          <input type="number" class="form-control input-small inline-selector" v-model="days_count" placeholder="Days Count" />
          @foreach (config('laravellocalization.supportedLocales') as $code => $lang)

            <input type="text" class="form-control input-medium inline-selector" 
              v-model="title['{{$code}}']" 
              placeholder="{{__('package::dashboard.packages.form.title') . '-' . $code}}" />
          @endforeach

          @foreach (config('laravellocalization.supportedLocales') as $code => $lang)
            <input type="text" class="form-control input-larg inline-selector" v-model="subscribe_duration_desc['{{$code}}']"
              placeholder=" @lang("Description {$code}")  ( @lang("line1 of Description,line2 of Description, ...") )" />
          @endforeach
          <label class="inline-selector-label-actions">
            <i @click="addPrice()" :class="`fa fa-plus ${price ? 'active' : 'deactive'}`"></i>
            <i @click="clearInputs()" :class="`fa fa-remove ${price || offer_percentage || start_offer_date || end_offer_date ? '' : 'deactive'}`"></i>
          </label>
        </div>
      </div>

      <div class="col-lg-12 notee" v-if="package_prices.length">
        <div v-for="priceItem in package_prices" :key="priceItem.key" class="price_item">
          <div class="form-group">
            <input :data-name="`package_prices.${priceItem.id}.action`" type="hidden" :name="`package_prices[${priceItem.id}][action]`"
              v-model="priceItem.action" />
            <input :data-name="`package_prices.${priceItem.id}.id`" type="hidden" :name="`package_prices[${priceItem.id}][id]`" v-model="priceItem.id" />
            <input :data-name="`package_prices.${priceItem.id}.price`" step="0.01" type="number" :name="`package_prices[${priceItem.id}][price]`" step=".01"
              class="form-control input-small inline-selector" v-model="priceItem.price" placeholder="price" />
            <input :data-name="`package_prices.${priceItem.id}.offer_percentage`" step="0.00" type="number"
              :name="`package_prices[${priceItem.id}][offer_percentage]`" step=".01" class="form-control input-small inline-selector"
              v-model="priceItem.offer_percentage" placeholder="Offer Percentage" />
            <input :data-name="`package_prices.${priceItem.id}.start_offer_date`" type="date" :name="`package_prices[${priceItem.id}][start_offer_date]`"
              class="form-control input-small inline-selector" v-model="priceItem.start_offer_date" placeholder="Offer start date" />
            <input :data-name="`package_prices.${priceItem.id}.end_offer_date`" type="date" :name="`package_prices[${priceItem.id}][end_offer_date]`"
              class="form-control input-small inline-selector" v-model="priceItem.end_offer_date" placeholder="Offer end date" />
            <input :data-name="`package_prices.${priceItem.id}.days_count`" type="number" :name="`package_prices[${priceItem.id}][days_count]`"
              class="form-control input-small inline-selector" v-model="priceItem.days_count" placeholder="Days Count" />

            @foreach (config('laravellocalization.supportedLocales') as $code => $lang)

              <input type="text" 
                :data-name="`package_prices.${priceItem.id}.title.{{$code}}`" :name="`package_prices[${priceItem.id}][title][{{$code}}]`"
                class="form-control input-medium inline-selector" 
                v-model="priceItem.title['{{$code}}']" 
                placeholder="{{__('package::dashboard.packages.form.title') . '-' . $code}}" 
              />
            @endforeach

            @foreach (config('laravellocalization.supportedLocales') as $code => $lang)
              <input type="text" :data-name="`package_prices.${priceItem.id}.subscribe_duration_desc.{{$code}}`"
                :name="`package_prices[${priceItem.id}][subscribe_duration_desc][{{$code}}]`" class="form-control input-larg inline-selector"
                v-model="priceItem.subscribe_duration_desc['{{$code}}']" placeholder="@lang("Description {$code}")  ( @lang("line1 of Description,line2 of Description, ...") )" />

            @endforeach

            <label class="inline-selector-label-actions">
              <i @click="removePriceItem(priceItem.key)" class="fa fa-remove active"></i>
            </label>
            <span class="help-block" style="margin: 0px 36px;">

            </span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@push('scripts')
<script src="{{ asset('admin/assets/global/plugins/vue@3.2.40/dist/vue.global.js') }}" type="text/javascript"></script>
<script>
  const { createApp } = Vue;
  createApp({
        data() {
            return {
              id: 1,
              action: 'create',
              price: null,
              offer_percentage: null,
              start_offer_date: null,
              end_offer_date: null,
              days_count: null,
              title: { },
              subscribe_duration_desc: { },
              package_prices: @json($package_prices),
            };
        },
        methods: {
            addPrice(){
                if(this.price){

                    this.package_prices.push({
                        id: this.id,
                        key: `${this.action}_${this.id}`,
                        action: this.action,
                        price: this.price,
                        offer_percentage: this.offer_percentage,
                        start_offer_date: this.start_offer_date,
                        end_offer_date: this.end_offer_date,
                        title: this.title,
                        subscribe_duration_desc: this.subscribe_duration_desc,
                        days_count: this.days_count,
                    });

                    this.id ++;
                    this.clearInputs();
                }
            },
            removePriceItem(key){
                let item = this.package_prices.map((priceItem) => priceItem.key).indexOf(key);
                if (item || item == 0) {
                    this.package_prices.splice(item, 1);
                    return true;
                }

                return false;
            },
            clearInputs(){
                this.price = null;
                this.offer_percentage = null;
                this.start_offer_date = null;
                this.end_offer_date = null;
                this.days_count = null;
                this.title ={ };
                this.subscribe_duration_desc ={ };
            },
        },
    }).mount('#app');
</script>
@endpush
