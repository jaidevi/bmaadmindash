<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserVehicle extends Model
{
    //
    protected $guarded = [];
    public $table = 'user_vehicle';
    protected $hidden = [
        'updated_at',
        'created_at',

    ];
    protected $appends = ['imageUri','modelYear'];
    public function getImageUriAttribute()
    {
        if (isset($this->attributes['image'])) {

            return url('upload/') . '/' . $this->attributes['image'];
        }
    }
    public function getModelYearAttribute()
    {
        if (isset($this->attributes['model'])) {

            return  $this->attributes['model'];
        }
        return null;
        // return  $this->attributes['model'];
    }
    public function Model()
    {
        return $this->belongsTo('App\VehicleModel', 'model_id', 'id');
    }
}
