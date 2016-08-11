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
	protected $user;
	protected $repo;
	function __construct(User $user)
	{
		$this->user = $user;
		$this->repo = new UserRepo($this->user);
	}
	public function me()
	{
		return $this->repo->userInfo(Auth::user()->id);
  	}
} 