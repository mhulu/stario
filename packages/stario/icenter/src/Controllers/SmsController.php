<?php
namespace Star\Icenter\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Star\Icenter\Forms\FireSmsFormRequest;
use Star\sms\MakeSMS;
use Star\sms\proxy\BechSmsProxy;

class SmsController extends Controller
{
  public function authCode(FireSmsFormRequest $request)
  {
  //   // preg_match('/\b\/.+/', $request->header('referer'), $matches);
  //   // if ($matches[0] == '/password/reset') {
  //   //   $mobile = $request['mobile'];
  //   //   $content = new MakeSMS;
  //   //   $sms = new BechSmsProxy($mobile, $content->makeCode($mobile));
  //   // } else {}
  //     $message = [
  //         'mobile.required' => '请填写手机号码',
  //         'mobile.unique' => '该手机已经注册，请返回直接登录'
  //     ];
  //     $validator = Validator::make($request->all(), [
  //         'mobile' => 'required|unique:users'
  //       ], $message);
  //     if ($validator->fails()) {
  //       $this->throwValidationException($request, $validator);
  //     }
  //     $mobile = $request['mobile'];
  //     $content = new MakeSMS;
  //     $sms = new BechSmsProxy($mobile, $content->makeCode($mobile));
  //     return $sms->fire();
    return $request->fire();
  }

}