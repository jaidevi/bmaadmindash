<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProviderPricing extends Model
{
    //
    public $table = 'provider_pricing';
    protected $fillable = [
        'provider_id', 'fuel_type', 'fuel_pricing'
    ];
    protected $appends = ['currency','title'];
    public function getCurrencyAttribute()
    {
        return    AdminSetting::first()->currency_symbol;
    }
    public function getFuelPricingAttribute($value)
    {
        return json_decode($value,true);

    }
    public function getTitleAttribute()
    {
        $s = SubFuelType::find($this->attributes['fuel_type']);
        $s->load('fuel:id,name');
        return $s['fuel']['name'] .' - '.$s['name'];
    }
}
