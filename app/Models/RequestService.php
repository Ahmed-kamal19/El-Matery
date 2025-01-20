<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Service;
use App\Models\City;
class RequestService extends Model
{
    use HasFactory;
    protected $table ='request_service';
    protected $guarded=['id'];
    protected $cast =[
        'created_at'=>'date:Y-m-d',
        'updated_at'=>'date:Y-m-d'
    ];


    public function service(){
        return $this->belongsTo(Service::class);
    }
    public function city(){
        return $this->belongsTo(City::class);
    }
}
