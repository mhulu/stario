<?php 
namespace App;

class SoapClass
{
	public function getUpload()
	{
		$data = '<jcdata><state>Y</state><result>成功</result></jcdata>';
		return new \SoapVar($data, XSD_ANYXML);
	}
}