<?php
namespace Star\Icenter\Controllers;

use App\Http\Controllers\Controller;

/**
 *
 */
class HomeController extends Controller
{	
      public function __construct()
      {
            $this->middleware('auth');
      }
	public function index()
	{
              return 'asdf';
  	}
  	public function menuList()
  	{
  		return $this->repo->menuList();
  	}
} 