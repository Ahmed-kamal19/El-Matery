<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarColorImage extends Model
{
    use HasFactory;
    protected $table = 'car_color_images';
    protected $guarded=[];
}
