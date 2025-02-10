<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use HasFactory,SoftDeletes;

    protected $guarded = [];
    protected $appends = [ 'name'  , 'description' ];
    protected $casts   = [
        'created_at' => 'date:Y-m-d',
        'updated_at' => 'date:Y-m-d'
    ];


    public function getNameAttribute()
    {
        return $this->attributes['name_' . getLocale() ];
    }

    // public function getTitleAttribute()
    // {
    //     return $this->attributes['title_' . getLocale() ];
    // }

    public function getDescriptionAttribute()
    {
        return $this->attributes['description_' . getLocale() ];
    }
    public function getPriceAfterVatAttribute()
    {
        // if (settings()->getSettings('maintenance_mode') == 1){
        //     return round($this->price * ( settings()->getSettings('tax') / 100 + 1));
        // }
        // else{
        //     return round($this->price);
        // }
        $price = ($this->discount_price !== null && $this->discount_price > 0) ? $this->discount_price : $this->price;

        if (settings()->getSettings('maintenance_mode') == 1) {
            return round($price * (settings()->getSettings('tax') / 100 + 1));
        } else {
            $price=0;
            return $price;
        }
    }
    public function features()
    {
        return $this->belongsToMany(Feature::class,'service_features','service_id','feature_id')->withPivot('description_ar', 'description_en');
    }
    public function getDiscountPriceAttribute()
    {
        return  $this->attributes['discount_price'] ? $this->attributes['discount_price'] : 0;
    }
    
   
    public function requestservice(){
        return $this->hasMany(RequestService::class);
    }
    
}
