<?php

namespace App;


use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;

class FuelProvider extends Authenticatable
{
    //

    use HasApiTokens, Notifiable;
    protected $fillable = [
        'name', 'email', 'phone_no', 'otp', 'status', 'image', 'password', 'device_token', 'noti', 'verified', 'is_featured', 'lat', 'lang','is_online','provider',
        'provider_token'
    ];
    protected $table = 'fuel_provider';
    protected $hidden = [
        'password', 'created_at', 'updated_at', 'otp'
    ];
    protected $appends = ['imageUri'];
    public function getImageUriAttribute()
    {
        if (isset($this->attributes['image'])) {

            return url('upload/') . '/' . $this->attributes['image'];
        }
    }
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }
    public function Shop()
    {
        return $this->hasMany('App\OwnerShop', 'owner_id', 'id');
    }
    public function scopeGetByDistance($query, $lat, $lang, $radius)
    {

        $results = DB::select(DB::raw('SELECT id, ( 3959 * acos( cos( radians(' . $lat . ') ) * cos( radians( lat ) ) * cos( radians( lang ) - radians(' . $lang . ') ) + sin( radians(' . $lat . ') ) * sin( radians(lat) ) ) ) AS distance FROM fuel_provider HAVING distance < ' . $radius . ' ORDER BY distance'));
        if (!empty($results)) {

            $ids = [];

            //Extract the id's
            foreach ($results as $q) {
                array_push($ids, $q->id);
            }
            return $query->whereIn('id', $ids);
        }
        return $query->whereIn('id', []);
    }

    public function getAvgRatingAttribute()
    {

        $revData = Review::where('provider_id', $this->attributes['id'])->get();
        $star = $revData->sum('star');
        if ($star > 1) {
            $t = $star / count($revData);
            return number_format($t, 1, '.', '');
        }
        return 0;
    }
    public function Reviews()
    {
        return $this->hasMany('App\Review', 'provider_id', 'id')->orderBy('created_at', 'desc');
    }
    public function Bookings()
    {
        return $this->hasMany('App\BookingMaster', 'provider_id', 'id')->orderBy('created_at', 'desc');
    }
    public function Pricing()
    {
        return $this->hasMany('App\ProviderPricing', 'provider_id', 'id')->orderBy('created_at', 'desc');
    }
}
