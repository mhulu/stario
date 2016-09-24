<?php

namespace Star\Health;

use Illuminate\Database\Eloquent\Model;

class Pop extends Model
{
	protected $guarded = [ 'id' ];
	public function health_record()
	{
		return $this->hasMany(PopHealthRecord::class);
	}
	public function setPasswordAttribute($password)
	{
		$this->attributes['password'] = \Hash::make($password);
	}
}
