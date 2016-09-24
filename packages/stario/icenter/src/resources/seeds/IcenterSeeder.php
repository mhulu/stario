<?php
namespace Star\Icenter\resources\seeds;

use Illuminate\Database\Seeder;
use Star\Icenter\App;
use Star\Icenter\Menu;
use Star\Icenter\Profile;
use Star\Icenter\Unit;
use Star\Icenter\User;
use Star\Permission\Models\Permission;
use Star\Permission\Models\Role;

class IcenterSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		// 创建一个用户
		$user = User::create([
			'mobile' => '18688889999',
			'password' => bcrypt('password'),
			'email' => 'demo@demo.com'
		]);

		// 创建一个部门
		$unit = Unit::create([
			'name' => '办公室'
		]);
		// 关联用户和部门
		
		Unit::find(1)->users()->save($user);

		// 创建一个用户资料
		$profile = Profile::create([
			'realname' => '刘德华',
				'avatar' => 'http://tva3.sinaimg.cn/crop.0.0.996.996.180/7b9ce441jw8f6jzisiqduj20ro0roq4k.jpg',
				'sex' => true,
				'birthplace' => 'LA',
				'birthYear' => 1977,
				'birthMonth' => 7,
				'birthDay' => 15,
			  	'qq' => '123321'
		]);

		//关联用户和资料
		User::find(1)->profiles()->save($profile);

		//创建一个应用
		$app = App::create([
			'name' => '内置应用',
			'description' => 'WeMesh系统内置应用',
			'icon' => 'codepen'
		]);
		$menus = [
	   // 父级菜单
	   // 所有的url必须开头冠以'/'
	   // 图标不需要加'fa-'
			[
				'name' => '控制面板',
				'url' => '/',
				'icon' => 'dashboard',
				'description' => '管理控制中心',
				'app_id' => 1,
				'parent_id' => 0
			],
			// [
			// 	'name' => '日程管理',
			// 	'url' => '/user/calendar',
			// 	'icon' => 'calendar',
			// 	'description' => '用于管理个人日程',
			// 	'app_id' => 1,
			// 	'parent_id' => 0
			// ],
			// [
			// 	'name' => '公告通知',
			// 	'url' => '/user/notify',
			// 	'icon' => 'bell-o',
			// 	'description' => '管理控制中心',
			// 	'app_id' => 1,
			// 	'parent_id' => 0
			// ],
			[
				'name' => '流动人口管理',
				'url' => '/pop',
				'icon' => 'street-view',
				'description' => '管理控制中心',
				'app_id' => 1,
				'parent_id' => 0
			],
			// [
			// 	'name' => '资讯发布',
			// 	'url' => 'post',
			// 	'icon' => 'send',
			// 	'description' => '日常新闻资讯发布',
			// 	'app_id' => 1,
			// 	'parent_id' => 0
			// ],
			[
				'name' => '用户管理',
				'url' => '/users',
				'icon' => 'user',
				'description' => '修改个人资料',
				'app_id' => 1,
				'parent_id' => 0
			],
			[
				'name' => '部门管理',
				'url' => '/unit',
				'icon' => 'group',
				'description' => '修改部门资料',
				'app_id' => 1,
				'parent_id' => 0
			],
			
		// 子级菜单
		// 第一梯队 无
		//第二梯队
			[
				'name' => '新建档案',
				'url' => '/pop/new',
				'icon' => 'plus',
				'description' => '创建一个流动人口档案',
				'app_id' => 1,
				'parent_id' => 2
			],
			[
				'name' => '编辑档案',
				'url' => '/pop/edit',
				'icon' => 'edit',
				'description' => '编辑已有流动人口档案',
				'app_id' => 1,
				'parent_id' => 2
			]
			// 第三梯队
			// [
			// 	'name' => '站内用户',
			// 	'url' => '/user',
			// 	'icon' => 'group',
			// 	'description' => '管理用户',
			// 	'app_id' => 1,
			// 	'parent_id' => 3
			// ],
			// [
			// 	'name' => '安全设置',
			// 	'url' => '/profile/security',
			// 	'icon' => 'pie-chart',
			// 	'description' => '修改自己的密码等',
			// 	'app_id' => 1,
			// 	'parent_id' => 3
			// ],
			//第四梯队
			// [
			// 	'name' => '修改部门资料',
			// 	'url' => 'unit',
			// 	'icon' => 'group',
			// 	'description' => '修改部门资料',
			// 	'app_id' => 1,
			// 	'parent_id' => 7
			// ],
			// [
			// 	'name' => '编辑部门人员',
			// 	'url' => 'unit',
			// 	'icon' => 'group',
			// 	'description' => '编辑部门人员',
			// 	'app_id' => 1,
			// 	'parent_id' => 7
			// ]
		];
		foreach ($menus as $menu) {
			Menu::create($menu);
		}

		//创建权限
		$permissionList = [
			['name' => 'manage apps', 'label' => '管理应用'],
			['name' => 'manage users', 'label' => '管理用户'],
			['name' => 'manage posts', 'label' => '管理文章'],
			['name' => 'manage menus', 'label' => '管理菜单']
		];
		foreach ($permissionList  as $permission) {
			Permission::create($permission);
		}

		//创建管理员角色
		$admin = Role::create([
			'name' => 'admin',
		   	'label' => '管理员'
		]);
		// $user = Role::create([
		// 	'name' => 'user',
		// 	'label' => '普通用户'
		// ]);

		foreach ($permissionList as $permission) {
			$admin->givePermissionTo($permission['name']);
		}
		$user->first()->assignRole('admin');
	}
}
