<?php

Route::any('popUpload', 'PopController@server');
Route::group(['prefix' => 'api', 'middleware' => 'throttle:60,1'], function () {
	// 健康表选填内容
	Route::get('classes', 'HealthController@classes');
	// 表单下拉选项
	Route::get('options', 'HealthController@options');

	// 流动人口自助查询
	Route::post('pop/patient', 'HealthController@patient');

	// 老人自助查询
	Route::post('geriatric/patient', 'HealthController@patient');

	// 流动人口修改密码
	Route::post('pop/password', 'HealthController@changePassword');

	// 老年人修改密码
	Route::post('geriatric/password', 'HealthController@changePassword');

	// TODO: 老人查体密码修改

	// 流动人口的后台管理接口，使用jwt middleware
	Route::resource('pop', 'PopController');
});