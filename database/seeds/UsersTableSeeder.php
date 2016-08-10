<?php

use Illuminate\Database\Seeder;
use Star\Permission\Models\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Role::create([
            'name' => 'admin',
           'name' => '管理员',
            'description' => '拥有最高权限,可以管理其他用户'
        ]);
    }
}
