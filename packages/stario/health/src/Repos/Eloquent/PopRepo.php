<?php
namespace Star\Health\Repos\Eloquent;

use Star\Health\Pop;
use Star\Health\Repos\Contracts\iPop;
use Star\Health\model;

/**
 * 流动人口的repository，实现自iBase
 */
class PopRepo implements iPop
{
	public $model;
	function __construct(Pop $model)
	{
		$this->model = $model;
	}

	public function all($columns = array ('*'))
	{
		return $this->model->get($columns);
	}

	public function paginate($perPage = 15, $columns = array('*'))
	{
        	return $this->model->paginate($perPage, $columns);
    	}

	public function with(array $relate)
	{
		return $this->model->with($relate)->get();
	}

	public function withByPaginate(array $relate, $perPage = 15)
	{
		return $this->model->with($relate)->paginate($perPage);
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

    	public function findBy($attr, $value, $columns = array('*'))
    	{
        	return $this->model->where($attr, '=', $value)->first($columns);
    	}

    	public function findWith($id, $columns = array('*'), array $relates)
    	{
    		return $this->model->with($relates)->get()->find($id, $columns);
    	}

}