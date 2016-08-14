<?php 
namespace Star\Icenter\Repos\Contracts;

interface iApp
{
	public function appList();
	public function addApp($data);
	public function removeApp(array $ids);
	public function editApp($id);
	public function showApp($id);
}