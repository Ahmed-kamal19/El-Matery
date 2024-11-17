<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\App;

class Brand extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];
    protected $appends = ['name', 'meta_keyword', 'meta_desc'];
    protected $casts = [
        'created_at' => 'date:Y-m-d',
        'updated_at' => 'date:Y-m-d'
    ];
    public function getNameAttribute()
    {
        return $this->attributes['name_' . getLocale()];
    }
    public function getMetaKeywordAttribute()
    {

        $locale            = App::getLocale();
        $metaKeywordColumn = 'meta_keyword_' . $locale;

        return $this->getAttribute($metaKeywordColumn);
    }

    public function getMetaDescAttribute()
    {
        return $this->getAttribute('meta_desc_' . App::getLocale());
    }


    public function models(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(CarModel::class);
    }

    public function cars(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Car::class);
    }

    public function oldCars(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Car::class)->where("is_new", 0);
    }

    public function newCars(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Car::class)->where("is_new", 1);
    }

    // public function countCars()
    // {
    //     return $this->cars->count();
    // }

    public function countCars()
    {
        return $this->hasMany(Car::class)->where('publish', 1)->where('show_in_home_page', 1);
    }
}
