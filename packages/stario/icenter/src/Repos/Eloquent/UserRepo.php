<?php 
namespace Star\Icenter\Repos\Eloquent;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Star\Icenter\Menu;
use Star\Icenter\Repos\Contracts\IUser;
use Star\Icenter\User;

class UserRepo implements IUser
{
	protected $user;
	public function __construct()
	{
		$this->user = User::find(Auth::user()->id);
	}
	public function userInfo()
	{
		if ($this->user) {
			return response()->json([
					'name' => empty($this->user->profiles->realname) ? $this->user->mobile : $this->user->profiles->realname,
					'avatar' => empty($this->user->profiles->avatar) ? 'http://static.stario.net/images/avatar.png' :$this->user->profiles->avatar,
					'role' => $this->user->roles->first()['label']
				], 200);
		}
		return response()->json([
				'result' => '获取不到用户信息'
			], 500);
	}

	public function menuList()
	{
		// return \Star\Permission\Models\Role::find(1)->permissions;
		return $this->buildTree(Menu::all());
	}

	public function has($column, $value)
	{
		return $this->user->where($column, $value)->first();
	}

 	private function buildTree(Collection $elements, $parent_id = 0)
    	{
       	 	$data = [];
       		 foreach ($elements as $element) {
       	     		if ($element->parent_id == $parent_id) {
       	        		$children = $this->buildTree($elements, $element->id);
       	         		if ($children) {
       	             			$element->submenu = $children;
       	         		}
       	         		$data[] = $element;
       	     		}
       		}
       		return $data;
   	 }

}