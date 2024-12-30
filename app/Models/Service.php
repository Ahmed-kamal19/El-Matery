<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $appends = [ 'name' , 'title' , 'description' ];
    protected $casts   = [
        'created_at' => 'date:Y-m-d',
        'updated_at' => 'date:Y-m-d'
    ];


    public function getNameAttribute()
    {
        return $this->attributes['name_' . getLocale() ];
    }

    public function getTitleAttribute()
    {
        return $this->attributes['title_' . getLocale() ];
    }

    public function getDescriptionAttribute()
    {
        return $this->attributes['description_' . getLocale() ];
    }
    public function getPriceAfterVatAttribute()
    {
        if (settings()->getSettings('maintenance_mode') == 1){
            return round($this->price * ( settings()->getSettings('tax') / 100 + 1));
        }
        else{
            return round($this->price);
        }
    }
}
