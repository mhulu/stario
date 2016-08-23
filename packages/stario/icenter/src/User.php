<?php

namespace Star\Icenter;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Star\Icenter\Profile;
use Star\Icenter\Unit;
use Star\Permission\Traits\HasRoles;
class User extends Authenticatable
{
    use HasRoles;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','mobile'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
    public function profiles()
    {
        return $this->hasOne(Profile::class);
    }
}
