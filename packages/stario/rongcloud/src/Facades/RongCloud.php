<?php
namespace Star\rongcloud\Facades;
use Illuminate\Support\Facades\Facade;
class RongCloud extends Facade
{
	protected static function getFacadeAccessor()
	{
		return 'rongcloud';
	}
}