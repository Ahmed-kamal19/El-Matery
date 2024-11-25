<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Feature extends Model
{
    use HasFactory,SoftDeletes;

    protected $guarded = ['id'];
    protected $casts = ['created_at' => 'date:Y-m-d', 'updated_at' => 'date:Y-m-d'];

    public function cars()
    {
        return $this->belongsToMany(Car::class, 'car_feature', 'feature_id', 'car_id');
    }}
