<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentTransaction extends Model
{
    //
    public $table = 'payment_transaction';

    protected $fillable = [
        'provider_id', 'booking_id', 'admin_share', 'provider_share', 'payment', 'shattle', 'shattle_at'
    ];
    protected $dates = [
        'created_at',
        'updated_at',
        'shattle_at',

    ];
    protected $appends = ['currency'];
    public function getCurrencyAttribute()
    {
        return    AdminSetting::first()->currency_symbol;
    }
    public function Provider()
    {
        return $this->belongsTo('App\FuelProvider', 'provider_id', 'id');
    }
    public function Booking()
    {
        return $this->belongsTo('App\Booking', 'booking_id', 'id');
    }
}
