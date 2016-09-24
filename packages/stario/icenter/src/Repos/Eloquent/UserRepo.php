<?php
namespace Star\Icenter\Repos\Eloquent;

use Illuminate\Database\Eloquent\Collection;
use Star\Icenter\Menu;
use Star\Icenter\Profile;
use Star\Icenter\Repos\Contracts\iUser;
use Star\Icenter\User;

class UserRepo implements iUser
{
	protected $user;
	function __construct()
	{
		$this->user = new User();
	}
        /**
         * 获取用户列表，显示基本资料，支持分页
         * @return json
         */
	public function getUserList()
	{
		if ( !isset($_GET['perpage']) ) {
			$users = $this->user->with('profiles')->get();
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
			$users = $this->user->with('profiles')->paginate($_GET['perpage']);
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
              $user = $this->user->findOrFail($id);
		if ($user->profiles) {
			return response()->json([
					'id'         => $user->id,
					'name'       => empty($user->profiles->realname) ? $user->mobile : $user->profiles->realname,
					'mobile'     => $user->mobile,
					'email'      => empty($user->email) ? '尚未填写' : $user->email,
					'avatar'     => empty($user->profiles->avatar) ? 'http://static.stario.net/images/avatar.png' : $user->profiles->avatar,
					'role'       => empty($user->roles->first()['label']) ? '普通用户' : $user->roles->first()['label'],
					'unit'       =>empty($user->unit->name) ? '尚未填写' : $user->unit->name,
					'sex'        => empty($user->profiles->sex ) ? '' : $user->profiles->sex==1 ? '男':'女',
					'qq' => empty($user->profiles->qq) ? '尚未填写' : $user->profiles->qq,
					'wechat' => empty($user->profiles->wechat) ? '尚未填写' : $user->profiles->wechat,
					'birthplace' => empty($user->profiles->birthplace) ? '尚未填写' : $user->profiles->birthplace,
                                  	'birthday' => $user->profiles->birthYear.'-'.$user->profiles->birthMonth.'-'.$user->profiles->birthDay,
					'last_login' => $user->last_login,
					'last_ip'    => $user->last_ip,
					'menuList'   => $this->menuList(),
					'events' => $this->events($id)->sortByDesc('id')->take(8)
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
      		$user = $this->user->create([
      			'mobile' => $data['newMobile'],
      			'password' => bcrypt($data['newPassword'])
      		]);
      		$profiles = Profile::create([
                                      'realname'=>$data['newMobile']
                                    ]);
      		$user->profiles()->save($profiles);
      		return $user;
      }

      public function events($id)
      {
      		$user = $this->user->findOrFail($id);
      		return $user->events;
      }

      public function updateUser($id, $data)
      {
      		$user = $this->user->findOrFail($id);
      		$user->profiles->realname = $data['name'];
      		$user->profiles->birthYear = $this->splitBirthday($data['birthday']);
      		$user->profiles->birthMonth = $this->splitBirthday($data['birthday'], 1);
      		$user->profiles->birthDay = $this->splitBirthday($data['birthday'], 2);
      		$user->profiles->sex = $data['sex'] == '男' ? 1 : 0; 
      		$user->profiles->qq = $data['qq'];
      		$user->email = $data['email'];
      		return $user->profiles->save();
      }

      /**
       * 生成菜单列表
       */
	private function menuList()
	{
		// return \Star\Permission\Models\Role::findOrFail(1)->permissions;
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

   	 private function splitBirthday($birthday, $index = 0)
   	 {
   	 	return explode('-', $birthday) [$index];
   	 }
}