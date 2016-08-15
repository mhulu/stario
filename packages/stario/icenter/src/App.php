<?php

namespace Star\Icenter;

use Illuminate\Database\Eloquent\Model;
use Star\Icenter\Menu;

class App extends Model
{
    public function menus()
    {
      return $this->hasMany(Menu::class);
    }
}
