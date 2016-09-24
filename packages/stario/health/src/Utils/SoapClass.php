<?php 
namespace Star\Health\Utils;

class SoapClass
{
	public function getUpload($passed = true)
	{
		if ($passed) {
			$data = '<jcdata><state>Y</state><result>成功</result></jcdata>';
		} else {
			$data = '<jcdata><state>N</state><result>失败</result></jcdata>';
		}
		return new \SoapVar($data, XSD_ANYXML);
	}
}