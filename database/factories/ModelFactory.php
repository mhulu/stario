<?php
use Faker\Factory as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

// $factory->define(App\Role::class, function (Faker\Generator $faker) {
//     $faker = Faker::create('zh_CN');
//     return [
//         'name' => $faker->unique()->randomElement(['管理员', '编辑', '普通用户']);
//         'slug' => $faker->unique()->randomElement(['Admin', 'Editor', 'User']);
//     ];
// });
// $factory->define(App\Permission::class, function (Faker\Generator $faker) {
//     $faker = Faker::create('zh_CN');
//     return [
//         'name' => $faker->unique()->randomElement(['浏览内容', '管理文章', '管理用户', '管理应用']);
//         'slug' => $faker->unique()->randomElement(['view post', 'manage posts', 'manage users', 'manage apps']);
//     ];
// });
$factory->define(App\User::class, function ($faker) {
    $faker = Faker::create('zh_CN');
    return [
        'name' => $faker->name,
        'mobile' => $faker->phoneNumber,
        'email' => $faker->email,
        'password' => bcrypt('wemesh')
    ];
});
