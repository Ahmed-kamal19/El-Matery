<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Offer extends Model
{
    use HasFactory,SoftDeletes;

    protected $guarded = ['cars'];
    // protected $appends = [ 'title' , 'description' ];
    protected $casts   = [
        'created_at' => 'date:Y-m-d',
        'updated_at' => 'date:Y-m-d'
    ];


    public function getTitleAttribute()
    {
        return $this->attributes['title_' . getLocale() ];
    }

    public function getDescriptionAttribute()
    {
        return $this->attributes['description_' . getLocale() ];
    }

    public function cars()
    {
        return $this->belongsToMany(Car::class, 'car_offer', 'offer_id', 'car_id');
    }

}
