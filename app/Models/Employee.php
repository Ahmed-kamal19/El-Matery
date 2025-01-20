<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class Employee extends Authenticatable
{
    use HasFactory;
    use Notifiable,SoftDeletes;

    protected $guarded = ['roles'];
    protected $appends = [''];
    protected $casts = ['created_at' => 'date:Y-m-d', 'updated_at' => 'date:Y-m-d'];


    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function getLogoPathAttribute()
    {
        return asset(getImagePathFromDirectory($this->logo, 'Admins', "default.svg"));
    }
    public function assignRole($role)
    {
        return $this->roles()->save($role);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class)->where('id', '!=', 2)->withTimestamps();
    }

    public function abilities()
    {
        return $this->roles->map->abilities->flatten()->pluck('name')->unique();
    }

    public function vendors()
    {
        return $this->hasMany(Vendor::class, 'created_by');
    }

}
