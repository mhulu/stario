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
        // $user->first->profile()->save($profile->first());

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
