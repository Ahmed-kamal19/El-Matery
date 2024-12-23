<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactUs extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $casts   = [
        'created_at' => 'date:Y-m-d',
        'updated_at' => 'date:Y-m-d'
    ];


}
