<?php 
namespace Star\Icenter\Repos\Contracts;

interface IUser
{
	public function getAllUserDetails();
	public function getUserDetailsById($id);
}