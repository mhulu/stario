<?php

namespace Star\Icenter;

use Illuminate\Database\Eloquent\Model;
use Star\Icenter\User;

class Profile extends Model
{
    protected $guarded = [
      'id'
    ];
    public function users()
    {
      return $this->hasOne(User::class);
    }
}
