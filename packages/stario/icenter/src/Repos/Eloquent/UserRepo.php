<?php 
namespace Star\Icenter\Repos\Eloquent;

use Star\Icenter\Repos\Contracts\IUser;
use Star\Icenter\User;

class UserRepo implements IUser
{
	protected $user;
	public function __construct(User $user)
	{
		$this->user = $user;
	}
	public function userInfo($id)
	{
		if ($user = $this->has('id', $id)) {
			return response()->json([
					'name' => empty($user->name) ? $user->mobile : $user->name,
					'avatar' => empty($user->avatar) ? 'http://static.stario.net/images/avatar.png' : $user->avatar,
					'role' => $user->roles->first()['label']
				], 200);
		}
		return response()->json([
				'msg' => '获取不到用户信息'
			], 500);
	}

	public function has($column, $value)
	{
		return $this->user->where($column, $value)->first();
	}

}