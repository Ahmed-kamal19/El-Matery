<?php

namespace App\Models;
use Illuminate\Support\Facades\App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CarModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "models";
    protected $guarded = [];
    protected $appends = ['name'];
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

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function categories(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Category::class);
    }

    public function cars()
    {
        return $this->hasMany(Car::class, 'model_id');
    }
    public function countCars()
    {
        return $this->hasMany(Car::class, 'model_id')->where('publish', 1)->where('show_in_home_page', 1);
    }
}
