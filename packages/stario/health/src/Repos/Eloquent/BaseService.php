<?php
namespace Star\Health\Repos\Eloquent;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Star\utils\CreateJson;

/**
 * 流动人口及老年人查体操作抽象类
 */
abstract class BaseService 
{
	protected $model;

	/**
	 * 定义调用的repo名称，比如'pop'或者'geriatric'什么的
	 * 具体名称在子类的构造方法中
	 * 定义方法 return 'pop';
	 * @return [String] [repo的具体名称]
	 */
	abstract public function model();
	abstract public function create(array $data);

	// 分页显示全部的流动人口数据
	public function index($paginate)
	{
		$data = $this->{$this->model()}->paginate($paginate, ['id', 'identify', 'name', 'sex', 'phone', 'address', 'birthday', 'check_unit', 'check_date', 'doctor', 'memo']);
               return CreateJson::create(100, $data);
	}

	public function show($id)
	{
		$cols = ['id', 'identify', 'name', 'sex', 'phone', 'address', 'birthday', 'check_unit', 'check_date', 'doctor', 'memo'];
		$data = $this->{$this->model()}->findWith($id, $cols, ['health_record']);
		if (empty($data->id)) {
			return CreateJson::create(404);
		}
		return CreateJson::create(100, $data);
	}

	public function update($data, $id)
	{	
		if ($this->{$this->model()}->update($data, $id)) {
			return CreateJson::create(200);
		}
		return CreateJson::create(304);
	}

	public function updatePassword($password, $id)
	{
		if ($this->{$this->model()}->update(['password' => Hash::make($password)], $id)) {
			return CreateJson::create(200, '密码已成功更新');
		}
		return CreateJson::create(304);
	}

	public function destroy($id)
	{
		if ($this->{$this->model()}->destroy($id)) {
			return CreateJson::create(200);
		}
		return CreateJson::create(403);
	}
	// 患者查询自己的信息
	public function patient($request)
	{
		$pop = $this->{$this->model()}->findBy('identify', $request->identify);
		if (empty($pop)) {
			return CreateJson::create(404);
		} elseif (Hash::check($request->password, $pop->password)) {
			return $this->show($pop->id);
		} else {
			return CreateJson::create(401);
		}
	}
	// 患者修改密码
	public function patientUpdatePassword($request)
	{
		$pop = $this->{$this->model()}->findBy('identify', $request->identify);
		if (empty($pop)) {
			return CreateJson::create(404);
		} elseif (Hash::check($request->password, $pop->password)) {
			return $this->updatePassword($request->newPassword, $pop->id);
		} else {
			return CreateJson::create(401);
		}
	}
}