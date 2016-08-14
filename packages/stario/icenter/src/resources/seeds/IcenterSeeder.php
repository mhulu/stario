<?php

use Illuminate\Database\Seeder;

class IcenterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
        	'mobile' => '18688889999',
        	'password' => bcrypt('password'),
        	'email' => 'demo@demo.com'        	
        ]);


        $unit = Unit::create([
        	'name' => '办公室'
        ]);

        $profile = Profile::create([
        	'realname' => '刘德华',
            	'avatar' => 'http://tva3.sinaimg.cn/crop.0.0.996.996.180/7b9ce441jw8f6jzisiqduj20ro0roq4k.jpg',
            	'sex' => true,
		'birthplace' => 'LA',
            	'year' => 1977,
            	'month' => 7,
            	'day' => 15,
            	'unit_id' => 1
        ]);

        $permissionList = [
        	['name' => 'manage apps', 'label' => '管理应用'],
        	['name' => 'manage users', 'label' => '管理用户'],
        	['name' => 'manage posts', 'label' => '管理文章'],
        	['name' => 'manage menus', 'label' => '管理菜单'],
        ];
        foreach ($permissionList  as $permission) {
        	Permission::create($permission);
        }

        $admin = Role::create([
            'name' => 'admin',
           'label' => '管理员',
            'description' => '拥有最高权限,可以管理其他用户'
        ]);

        foreach ($permissionList as $permission) {
        	$admin->gievePermissionTo($permission['name']);
        }
        $user->assignRole('admin');

    }
}
