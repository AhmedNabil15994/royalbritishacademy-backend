<?php

namespace Modules\Package\Entities;

use Illuminate\Database\Eloquent\Model;
use IlluminateAgnostic\Collection\Support\Carbon;
use Modules\Core\Traits\Dashboard\CrudModel;
use Modules\Core\Traits\HasTranslations;

class PackagePrice extends Model
{
    use HasTranslations;
    use CrudModel;
    protected $guarded = ["id"];
    protected $appends = ["active_price"];
    public $translatable = ['subscribe_duration_desc','title'];

    public function package()
    {
        return $this->belongsTo(Package::class, "package_id");
    }

    public function getActivePriceAttribute()
    {
        $kw = __('kw');
        if($this->offer_percentage && $this->offer_percentage > 0){

            $startDate = $this->start_offer_date ? Carbon::createFromFormat('Y-m-d', $this->start_offer_date) : Carbon::now()->subDay();
            $endDate = $this->end_offer_date ? Carbon::createFromFormat('Y-m-d', $this->end_offer_date) : Carbon::now()->addDay();
            
            if(Carbon::now()->between($startDate,$endDate)){
                $price = calculateOfferAmountByPercentage($this->price,$this->offer_percentage);
                return [
                    'price' => calculateOfferAmountByPercentage($this->price,$this->offer_percentage),
                    'price_html' => "<div class=\"price\">{$price} {$kw}<del class=\"discount\">{$this->price} {$kw}</del></div>",
                ];
            }
        }

        return [
            'price' => $this->price,
            'price_html' => "<div class=\"price\">{$this->price} {$kw}</div>",
        ];
    }

    public function getHasOfferKnowAttribute()
    {
        $startDate = $this->start_offer_date ? Carbon::createFromFormat('Y-m-d', $this->start_offer_date) : Carbon::now()->subDay();
        $endDate = $this->end_offer_date ? Carbon::createFromFormat('Y-m-d', $this->end_offer_date) : Carbon::now()->addDay();

        $check = Carbon::now()->between($startDate,$endDate);
        
        return $check && $this->offer_percentage;
    }
}
