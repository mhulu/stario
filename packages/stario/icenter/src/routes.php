<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Authorization, Content-Type');
header('Content-Type: application/x-www-form-urlencoded; charset=UTF-8');
header('Access-Control-Allow-Methods:  POST, GET, PUT, DELETE');

// Route::get('/', ['uses' => 'HomeController@index', 'middleware' => 'web']);
Route::get('/', 'HomeController@index');
Route::group(['prefix' => 'api', 'middleware' => 'throttle:60,1'], function () {
  Route::post('getsms','SmsController@authcode');
  Route::post('signup','UserController@signup');

  Route::group(['prefix' => 'auth'], function () {
    Route::post('login', 'Auth\AuthController@login');
    Route::get('refreshToken', 'Auth\AuthController@refreshToken');
  });
  Route::group(['middleware' => ['jwt.auth', 'throttle:60,1']], function () {
    Route::resource('user', 'UserController');
    Route::get('user/me', 'UserController@show');
    // Route::get('user/profile/{$id}', 'UserController@getUserInfo');
    // Route::post('create', 'UserController@create');
  });
});