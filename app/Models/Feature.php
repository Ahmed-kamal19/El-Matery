<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Feature extends Model
{
    use HasFactory,SoftDeletes;

    protected $guarded = ['id'];
    protected $appends = ['title'];
    protected $casts   = [
        'created_at' => 'date:Y-m-d',
        'updated_at' => 'date:Y-m-d'
    ];
    public function cars()
    {
        return $this->belongsToMany(Car::class, 'car_feature', 'feature_id', 'car_id');
    }
    public function getTitleAttribute()
    {
        return $this->attributes['title_'.app()->getLocale()];
    }
    public function services()
    {
        return $this->belongsToMany(Service::class,'service_features','feature_id','service_id');
    }
    public function getDescriptionAttribute()
    {
        // Dynamically determine the description key based on the current locale
        $descriptionKey = 'description_' . app()->getLocale();

        // Return the pivot value for the dynamic key if it exists
        return $this->pivot && isset($this->pivot->{$descriptionKey})
            ? $this->pivot->{$descriptionKey}
            : null; // Return null if the key doesn't exist
    }
}
