<?php
namespace Star\Health\Repos\Contracts;

Interface iBase
{
	public function all($columns = array('*'));

	public function with(array $relate);

  	public function withByPaginate(array $relate, $perPage = 15);

	public function paginate($perPage = 15, $columns = array('*'));

	public function create(array $data);

  	public function save(array $data);

	public function update(array $data, $id);

	public function destroy($id);

	public function find($id, $columns = array('*'));

	public function findBy($field, $value, $columns = array('*'));

  	public function findWith($id, $columns = array('*'), array $relates);

  } 