<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Feature extends Model
{
    use HasFactory,SoftDeletes;

    protected $guarded = ['id'];

    public function cars()
    {
        return $this->belongsToMany(Car::class, 'car_feature', 'feature_id', 'car_id');
    }}
