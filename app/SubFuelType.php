<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubFuelType extends Model
{
    //

    public $table = 'sub_fuel_type';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'name', 'fuel_type', 'status', 'measurement_unit'
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
   
    public function Fuel()
    {
        return $this->belongsTo('App\FuelType', 'fuel_type', 'id')->where('status', 1);
    }
}
