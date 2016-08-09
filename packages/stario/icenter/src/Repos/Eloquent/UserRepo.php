<?php 
namespace Star\Icenter\Repos\Eloquent;

use Star\Icenter\Repos\Contracts\IUser;
use Star\Icenter\User;

class UserRepo implements IUser
{
	public function getAllUserDetails()
	{
		return User::all();
	}
	public function getUserDetailsById($id)
	{
		# code...
	}
}