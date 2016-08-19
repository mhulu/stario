<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Authorization, Content-Type');
header('Access-Control-Allow-Methods:  POST, GET, OPTIONS, PUT, DELETE');

Route::get('/', ['uses' => 'HomeController@index', 'middleware' => 'web']);

Route::group(['prefix' => 'api', 'middleware' => 'throttle:60,1'], function () {
  Route::group(['prefix' => 'auth'], function () {
    Route::post('login', 'Auth\AuthController@login');
    Route::get('refreshToken', 'Auth\AuthController@refreshToken');
  });
  Route::group(['prefix' => 'user', 'middleware' => ['jwt.auth', 'throttle:60,1']], function () {
    Route::get('me', 'UserController@me');
    Route::get('menu', 'UserController@menuList');
  });
});
