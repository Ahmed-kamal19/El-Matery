<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class CarColorImage extends Pivot
{
    use HasFactory;
    protected $table = 'car_color_images';
    protected $guarded=[];
    protected $appends = ['full_image_path'];

    public function getFullImagePathAttribute()
    {
        return asset(getImagePathFromDirectory($this->image,'Cars'));
    }
    public function color()
    {
        return $this->belongsTo(Color::class, 'color_id');
    }
    
}
