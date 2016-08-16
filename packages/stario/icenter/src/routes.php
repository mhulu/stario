<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Authorization, Content-Type');
header('Access-Control-Allow-Methods:  POST, GET, OPTIONS, PUT, DELETE');

Route::group(['prefix' => 'api'], function () {
  Route::group(['prefix' => 'auth'], function () {
    Route::post('login', 'AuthController@login');
    Route::post('refreshToken', ['uses' => 'AuthController@refreshToken',  'middleware' => 'jwt.refresh']);
  });
  Route::group(['prefix' => 'user', 'middleware' => 'jwt.auth'], function () {
    Route::get('me', 'UserController@me');
    Route::get('menu', 'UserController@menuList');
  });
});
