<?php

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

$factory->define(App\Role::class, function (Faker\Generator $faker) {
    $faker = Faker::create('zh_CN');
    return [
        'name' => $faker->unique()->randomElement(['Admin'])
    ];
});

$factory->define(App\User::class, function (Faker\Generator $faker) {
    $faker = Faker::create('zh_CN');
    return [
        'name' => $faker->name,
        'mobile' => $faker->phoneNumber,
        'email' => $faker->email,
        'password' => bcrypt('wemesh')
    ];
});
