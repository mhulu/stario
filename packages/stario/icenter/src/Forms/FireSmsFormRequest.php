<?php

namespace Star\Icenter\Forms;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Star\Icenter\Forms\FormRequest;
use Star\Icenter\Repos\Eloquent\UserRepo;
use Star\Icenter\User;
use Star\sms\MakeSMS;
use Star\sms\proxy\BechSmsProxy;

 class FireSmsFormRequest extends FormRequest
{
    protected $user;
    public function __construct(UserRepo $user)
    {
        $this->user = $user;
    }

    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'mobile' => 'required|max:11'
        ];
    }

    // 存储入库，如果发现?findpass则更新密码
    public function fire()
    {
        if (isset($_GET['findpass'])) {
            return $this->forReset();
        } 
        return $this->forNormal();
    }

    private function forReset() {
        $mobile = $this->request->all()['mobile'];
        if ($this->user->has('mobile', $mobile)) {
            $proxy = new BechSmsProxy($this->mobile, MakeSMS::makeCode($mobile));
            return $proxy->fire();
        }
        return response()->json(['result' => '该手机号没有注册，请返回注册']);
    }

    private function forNormal() {
        $mobile = $this->request->all()['mobile'];
        if ($this->user->has('mobile', $mobile)) {
            return response()->json(['result' => '该手机号已经注册，请直接登陆'], 403);
        }
            $proxy = new BechSmsProxy($mobile, MakeSMS::makeCode($mobile));
            return $proxy->fire();
    }

}