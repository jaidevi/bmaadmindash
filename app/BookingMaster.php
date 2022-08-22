<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class BookingMaster extends Model
{
    //
    protected $guarded = [];
    public $table = 'booking_master';
    protected $appends = ['currency'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('orderStatus', function (Builder $builder) {
            $builder->orderby('time', 'desc');
        });
    }
    public function getCurrencyAttribute()
    {
        return    AdminSetting::first()->currency_symbol;
    }
    public function Model()
    {
        return $this->belongsTo('App\UserVehicle', 'vehicle_id', 'id');
    }
    public function User()
    {

        return  $this->belongsTo('App\AppUsers', 'user_id', 'id');
    }
    public function Provider()
    {

        return  $this->belongsTo('App\FuelProvider', 'provider_id', 'id');
    }
    public function Review()
    {
        return $this->hasOne('App\Review', 'booking_id', 'id');
    }
}
