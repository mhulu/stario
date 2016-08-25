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
	public function getUserList()
	{
		// if (isset($_GET['perpage']) && !empty($_GET['perpage'])) {
		// 	$perpage = $_GET['perpage'];
		// } else {
		// 	$perpage = 15;
		// }
		$perpage = isset($_GET['perpage']);
		if (empty($perpage)) {
			$users = User::with('profiles')->get();
		} else {
			$users = User::with('profiles')->paginate($perpage);
		}
		return $users = User::with('profiles')->paginate(1);
		$result = [
			$users->map(function ($item){
				return [
					'id' => $item->id,
					'name' => empty($item->profiles['realname']) ? '暂无' : $item->profiles['realname'],
					'mobile' => $item->mobile,
					'email' => empty($item->email) ? '暂无' : $item->email,
					'avatar' => empty($item->profiles['avatar']) ? 'http://static.stario.net/images/avatar.png' :$item->profiles['avatar'],
					'role' => $item->roles->first()['label'],
					'unit'       =>$item->unit->name,
					'sex'        => $item->profiles['sex'] ? '男' : '女',
					'birthplace' => $item->profiles['birthplace'],
					'birthday'   => $item->profiles['birthYear']. '年' .$item->profiles['birthMonth'].'月'.$item->profiles['birthDay'].'日',
					'last_login' => $item->last_login,
					'last_ip'    => $item->last_ip
				];
			})
		];
		// if (!empty($perpage)) {
		// 	$paginateList = [
		// 		$users->map(function ($item) {
		// 			return [
		// 				''
		// 			];
		// 		})
		// 	];
		// }
		return $result;
	}
	public function getUserInfo($id)
	{
              $user = User::find($id);
		if ($user) {
			return response()->json([
					'id'         => $user->id,
					'name'       => empty($user->profiles->realname) ? $user->mobile : $user->profiles->realname,
					'mobile'     => $user->mobile,
					'email'      => empty($user->email) ? '暂无' : $user->email,
					'avatar'     => empty($user->profiles->avatar) ? 'http://static.stario.net/images/avatar.png' :$user->profiles->avatar,
					'role'       => $user->roles->first()['label'],
					'unit'       =>$user->unit->name,
					'sex'        => $user->profiles->sex ? '男' : '女',
					'birthplace' => $user->profiles->birthplace,
					'birthday'   => $user->profiles->birthYear. '年' .$user->profiles->birthMonth.'月'.$user->profiles->birthDay.'日',
					'last_login' => $user->last_login,
					'last_ip'    => $user->last_ip,
					'menuList'   => $this->menuList()
				], 200);
		}
		return response()->json([
				'result' => '获取不到用户信息'
			], 500);
	}

      public function has($column, $value)
      {
        return $this->user->where($column, $value)->first();
      }

      public function create(Request $request)
      {
        return $request;
      }

	private function menuList()
	{
		// return \Star\Permission\Models\Role::find(1)->permissions;
		return $this->buildTree(Menu::all());
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