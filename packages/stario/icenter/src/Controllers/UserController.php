<?php
namespace Star\Icenter\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use Star\Icenter\Repos\Eloquent\UserRepo;

/**
 *
 */
 class UserController extends Controller
 {
	public function index()
	 	{	
	 		$repo = new UserRepo;
	 		return $repo->getAllUserDetails();
	 	} 	
 } 