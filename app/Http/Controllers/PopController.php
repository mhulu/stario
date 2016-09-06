<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Star\utils\Serializer;

class PopController extends Controller
{
    public function server()
    {
                if ($rawPostData = file_get_contents("php://input")) {
                    Log::info($rawPostData);
                }
      		$result = Serializer::xmlDecode($rawPostData);
      		$data = Serializer::parse($result['v:Body']['getUpload']['dataXML']['#']);
      		$baseInfo = $data['jmxx'];
      		$sickInfo = $data['jcjgs'];

      		dd($sickInfo);
      		// return $this->responsor();
    }
    private function responsor()
    {
    		$options = array('soap_version' => SOAP_1_2, 'uri' => 'http://homestead.app/popUpload');
                $soap = new \SoapServer(null, $options);
                $soap->setClass('App\SoapClass');

                $response = new Response();
                $response->headers->set('Content-Type','text/xml; charset=utf-8');

                ob_start();
                $soap->handle();
                $response->setContent(ob_get_clean());

                // 必须返回成功标识
                return $response;
    }
}
