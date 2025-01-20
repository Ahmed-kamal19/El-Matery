<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Otp extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded =[];
    protected $cast = [
        'created_at'=>'datetime',
        'updated_at'=>'datetime',
        'deleted_at'=>'deleted_at'
    ];
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
