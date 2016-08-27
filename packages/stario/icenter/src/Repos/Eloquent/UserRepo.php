<?php
namespace Star\Icenter\Repos\Eloquent;

use Illuminate\Database\Eloquent\Collection;
use Star\Icenter\Menu;
use Star\Icenter\Repos\Contracts\iUser;
use Star\Icenter\User;

class UserRepo implements iUser
{
        /**
         * 获取用户列表，显示基本资料，支持分页
         * @return json
         */
	public function getUserList()
	{
		if ( !isset($_GET['perpage']) ) {
			$users = User::with('profiles')->get();
                      $result = [
                            $users->map(function ($item) {
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
		} else {
			$users = User::with('profiles')->paginate($_GET['perpage']);
                      $data = collect($users->items());
                      $paginate = [
                        'total' => $users->total(),
                        'currentPage' => $users->currentPage(),
                        'perPage' => $users->perPage(),
                        'lastPage' => $users->lastPage(),
                        'from' => $users->firstItem(),
                        'to' => $users->lastItem()
                      ];
                      $info = [
                        'data' => $data->map(function ($item) {
                          return [
                                'id' => $item->id,
                                'name' => $item->profiles['realname'],
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
                      $result = array_merge($info, $paginate);
		}
              return response()->json($result, 200);
	}
  /**
   * 获取指定用户信息资料
   * @param  int $id 用户id
   * @return json
   */
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
					'birthYear'   => $user->profiles->birthYear,
                                     'birthMonth' => $user->profiles->birthMonth,
                                     'birthDay' => $user->profiles->birthDay,
					'last_login' => $user->last_login,
					'last_ip'    => $user->last_ip,
					'menuList'   => $this->menuList()
				], 200);
		}
		return response()->json([
				'result' => '获取不到用户信息'
			], 500);
	}
  /**
   * 查找是否有指定字段的该值
   * @param  [string]  $column [数据库字段名称]
   * @param  [mixed]  $value  [判断的值]
   * @return mixed         [返回判断结果，不存在返回false]
   */
      public function has($column, $value)
      {
        return $this->user->where($column, $value)->first();
      }

      public function createUser($data)
      {

      }

      /**
       * 生成菜单列表
       */
	private function menuList()
	{
		// return \Star\Permission\Models\Role::find(1)->permissions;
		return $this->buildTree(Menu::all());
	}
  /**
   * 遍历生成菜单结构
   * @param  Collection $elements  [description]
   * @param  integer    $parent_id [description]
   * @return [type]                [description]
   */
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