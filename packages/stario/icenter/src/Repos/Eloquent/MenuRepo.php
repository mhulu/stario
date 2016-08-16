<?php 
namespace Star\Icenter\Repos\Eloquent;

use Star\Icenter\Menu;

/**
* 
*/
class MenuRepo implements iMenu
{
  
  protected $menu;
  public function __construct(Menu $menu)
  {
    $this->menu = $menu;
  }

  public function all()
  {
    return Auth::user()->menus;
  }
}