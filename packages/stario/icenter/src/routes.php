<?php
Route::group(['prefix' => 'api', 'middleware' => 'cors'], function () {
  Route::group(['prefix' => 'auth'], function () {
    Route::post('login', 'AuthController@login');
  });
  Route::group(['prefix' => 'user', 'middleware' => 'jwt.auth'], function () {
    Route::get('all', 'UserController@index');
  });
});
