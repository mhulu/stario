<?php
namespace Star\Health\Repos\Eloquent;

use Star\Health\PopHealthRecord;
use Star\Health\Repos\Contracts\iPopHealthRecord;
use Star\Health\record;

class PopHealthRecordRepo implements iPopHealthRecord
{
	public $model;
	public $pop;
	
	public function __construct(PopHealthRecord $model)
	{
		$this->model = $model;
		$this->pop = $this->model->pop();
	}

	public function all($columns = array ('*'))
	{
		return $this->model->get($columns);
	}

	public function paginate($perPage = 15, $columns = array('*'))
	{
		return $this->model->paginate($perPage, $columns);
	}

	public function with(array $model)
	{
		return $this->record->with($model)->get();
	}

	public function withByPaginate(array $model, $perPage = 15)
	{
		return $this->record->with($model)->paginate($perPage);
	}

	public function create(array $data)
	{
		return $this->model->create($data);
	}

	public function save(array $data)
	{
		foreach ($data as $key => $value) {
			$this->model->$key = $value;
		}
		return $this->model->save();
	}

	public function update(array $data, $id)
	{
		return $this->model->where('id', $id)->update($data);
	}

	public function destroy($id)
	{
		return $this->model->destroy($id);
	}

	public function find($id, $columns = array('*'))
	{
		return $this->model->find($id, $columns);
	}

	public function findBy($attribute, $value, $columns = array('*'))
	{
		return $this->model->where($attribute, '=', $value)->first($columns);
	}

	public function findWith($id, $columns = array('*'), array $relates)
	{
		return $this->model->with($relates)->get()->find($id, $columns);
	}

}