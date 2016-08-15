<?php
namespace Star\Icenter\resources\seeds;

use Illuminate\Database\Seeder;
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
            	'unit_id' => 1
        ]);

        //关联用户和资料
        User::find(1)->profiles()->save($profile);

        //创建一个应用
        $app = App::create([
            'name' => '内置应用',
            'description' => 'WeMesh系统内置应用',
            'icon' => 'fa-codepen'
        ]);

        $menus = [
       // 父级菜单
            [
            'name' => '控制面板',
            'url' => '/',
            'icon' => 'fa-dashboard',
            'description' => '管理控制中心',
            'app_id' => 1,
            'parent_id' => 0
            ],
            [
            'name' => '用户管理',
            'url' => 'profile',
            'icon' => 'fa-user',
            'description' => '修改个人资料',
            'app_id' => 1,
            'parent_id' => 0
            ],
            [
            'name' => '部门管理',
            'url' => 'unit',
            'icon' => 'fa-group',
            'description' => '修改部门资料',
            'app_id' => 1,
            'parent_id' => 0
            ],
            [
            'name' => '资讯发布',
            'url' => 'post',
            'icon' => 'fa-send',
            'description' => '日常新闻资讯发布',
            'app_id' => 2,
            'parent_id' => 0
            ],
        // 子级菜单
        //第一梯队
            [
            'name' => '群发功能',
            'url' => 'mass-send',
            'icon' => 'reply_all',
            'description' => '群发功能',
            'app_id' => 1,
            'parent_id' => 1
            ],
            [
            'name' => '自动回复',
            'url' => 'auto-reply',
            'icon' => 'reply',
            'description' => '自动回复',
            'app_id' => 1,
            'parent_id' => 1
            ],
            [
            'name' => '自定义菜单',
            'url' => 'custom-menu',
            'icon' => 'th-list',
            'description' => '自定义菜单',
            'app_id' => 1,
            'parent_id' => 1
            ],
            [
            'name' => '投票管理',
            'url' => 'vote',
            'icon' => 'fa-thumbs-o-up',
            'description' => '投票管理',
            'app_id' => 1,
            'parent_id' => 1
            ],
         
            // 第三梯队
            [
            'name' => '用户分析',
            'url' => 'user-analysis',
            'icon' => 'male',
            'description' => '用户分析',
            'app_id' => 1,
            'parent_id' => 3
            ],
            [
            'name' => '图文分析',
            'url' => 'app-analysis',
            'icon' => 'pie-chart',
            'description' => '图文分析',
            'app_id' => 1,
            'parent_id' => 3
            ],
            [
            'name' => '菜单分析',
            'url' => 'menu-analysis',
            'icon' => 'bar-chart',
            'description' => '菜单分析',
            'app_id' => 1,
            'parent_id' => 3
            ],
            [
            'name' => '消息分析',
            'url' => 'message-analysis',
            'icon' => 'fa-file-audio-o',
            'description' => '消息分析',
            'app_id' => 1,
            'parent_id' => 3
            ]
        ];
        foreach ($menus as $menu) {
            Menu::create($menu);
        }

        //创建权限
        $permissionList = [
        	['name' => 'manage apps', 'label' => '管理应用'],
        	['name' => 'manage users', 'label' => '管理用户'],
        	['name' => 'manage posts', 'label' => '管理文章'],
        	['name' => 'manage menus', 'label' => '管理菜单'],
        ];
        foreach ($permissionList  as $permission) {
        	Permission::create($permission);
        }

        //创建管理员角色
        $admin = Role::create([
            'name' => 'admin',
           'label' => '管理员'
        ]);

        foreach ($permissionList as $permission) {
        	$admin->givePermissionTo($permission['name']);
        }
        $user->first()->assignRole('admin');
    }
}
