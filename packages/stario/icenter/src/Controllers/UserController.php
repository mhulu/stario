<?php
namespace Star\Icenter\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Star\Icenter\Repos\Eloquent\UserRepo;
use Star\Icenter\User;

/**
 *
 */
class UserController extends Controller
{	
	protected $repo;
	function __construct()
	{
		$this->repo = new UserRepo();
	}
	public function me()
	{
		return $this->repo->userInfo();
  	}
  	public function menuList()
  	{
  		return $this->repo->menuList();
  	}
} 