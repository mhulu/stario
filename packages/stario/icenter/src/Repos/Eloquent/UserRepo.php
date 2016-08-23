<?php
namespace Star\Icenter\Repos\Eloquent;

use Illuminate\Database\Eloquent\Collection;
use Star\Icenter\Menu;
use Star\Icenter\Repos\Contracts\iUser;
use Star\Icenter\User;

class UserRepo implements iUser
{
	// protected $user;
	// public function __construct()
	// {
	// 	$this->user = new User;
	// }
	public function getUserInfo($id)
	{
              $user = User::find($id);
		if ($user) {
			return response()->json([
                                     'id' => $user->id,
					'name' => empty($user->profiles->realname) ? $user->mobile : $user->profiles->realname,
                                     'mobile' => $user->mobile,
                                     'email' => empty($user->email) ? '暂无' : $user->email,
					'avatar' => empty($user->profiles->avatar) ? 'http://static.stario.net/images/avatar.png' :$user->profiles->avatar,
					'role' => $user->roles->first()['label'],
                                      'unit' =>$user->unit->name,
                                      'sex' => $user->profiles->sex ? '男' : '女',
                                      'birthplace' => $user->profiles->birthplace,
                                      'birthday' => $user->profiles->birthYear. '年' .$user->profiles->birthMonth.'月'.$user->profiles->birthDay.'日',
                                      'last_login' => $user->last_login,
                                      'last_ip' => $user->last_ip
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