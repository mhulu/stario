<?php
namespace Star\Health\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Star\Health\Repos\Eloquent\PopService;
use Star\utils\CreateJson;

/**
 * 本类不需要jwt::auth，针对病患开放
 * 用于对外控制流动人口[Pop]和老年人[Geriatric]查体
 */

class HealthController extends Controller
{
	protected $popService;
	public function __construct(PopService $popService)
	{
		$this->popService = $popService;
	}
	
	public function patient(Request $request)
	{
		$path = explode('/', $request->path())[1];
		if (empty($path)) {
			return CreateJson::create(404);
		}
		return $this->{$path.'Service'}->patient($request);
	}
	public function changePassword(Request $request)
	{
		$path = explode('/', $request->path())[1];
		if (empty($path)) {
			return CreateJson::create(404);
		}
		return $this->{$path.'Service'}->patientUpdatePassword($request);
	}
	/**
	 * 提供表单常用下拉选项
	 * @return json
	 */
	public function options()
	{
		$options = config('health');
		return CreateJson::create(200, $options);
	}
}
