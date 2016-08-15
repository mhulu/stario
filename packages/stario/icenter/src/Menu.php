<?php

namespace Star\Icenter;

use Illuminate\Database\Eloquent\Model;
use Star\Icenter\App;

class Menu extends Model
{
    public function apps()
    {
      return $this->belongsTo(App::class);
    }
}
