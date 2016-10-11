<?php 
namespace Star\sms;

use Illuminate\Support\Facades\Cache;

/**
 * 生成短信内容
 */
class MakeSMS
{
    private $content;

   /**
    * 生成验证码后根据配置模板生成内容，并添加缓存（存储5分钟）
    * @param  [type]  $key   [缓存key，如手机号码]
    * @param  integer $len [验证码位数]
    */
    public static function makeCode($key, $len = 6)
    {
    	$code = self::randomNum($len);
    	Cache::put($key, $code, 5);
    	$pattern = '/{\w+}/';
        	$content = preg_replace($pattern, $code, \Config::get('sms.Templates.authcode'));
        	return $content;
    }

    private static function randomNum($len = 4)
    {
        return str_pad(rand(0, pow(10, $len) -1), $len, '0', STR_PAD_LEFT);
    }
}
