<?php
// header('Access-Control-Allow-Origin: *');
// header( 'Access-Control-Allow-Headers: Authorization, Content-Type' );
// header('Access-Control-Allow-Methods: GET, POST, OPTIONS, DELETE');

Route::any('popUpload', 'PopController@server');

Route::get('/home', 'HomeController@index');
