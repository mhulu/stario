<?php

namespace Star\Icenter;

use Illuminate\Database\Eloquent\Model;
use Star\Icenter\User;

class Unit extends Model
{
    public function users()
    {
      return $this->hasMany(User::class);
    }
}
