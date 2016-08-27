<?php
// header('Access-Control-Allow-Origin: *');
// header( 'Access-Control-Allow-Headers: Authorization, Content-Type' );
// header('Access-Control-Allow-Methods: GET, POST, OPTIONS, DELETE');

Route::any('test', 'TestController@server');
Route::auth();

Route::get('/home', 'HomeController@index');
