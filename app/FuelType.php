<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FuelType extends Model
{
    //

    public $table = 'fuel_type';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name', 'icon', 'is_trending', 'status'
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    protected $appends = ['imageUri'];
    public function getImageUriAttribute()
    {
        if (isset($this->attributes['icon'])) {

            return url('upload/') . '/' . $this->attributes['icon'];
        }
    }
    public function SubFuelType()
    {
        return $this->hasMany('App\SubFuelType', 'fuel_type', 'id')->where('status', 1);
    }
}
