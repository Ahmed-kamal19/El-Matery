<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use HasFactory;
    protected $fillable = ['image'];
    protected $appends = ['full_image_path'];

    protected $casts = [
        'created_at' => 'date:Y-m-d',
        'updated_at' => 'date:Y-m-d'
    ];

    public function getFullImagePathAttribute()
    {
        return asset(getImagePathFromDirectory($this->image, 'Partners', "default.svg"));
    }
}
