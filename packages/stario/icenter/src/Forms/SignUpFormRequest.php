<?php

namespace Star\Icenter\Forms;

use App\Http\Requests\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Star\Icenter\Repos\Eloquent\UserRepo;
use Star\Icenter\User;

class SignUpFormRequest extends FormRequest
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
            'mobile' => 'required|max:11',
            'password' => 'required',
            'authCode' => 'required'
        ];
    }

    // 存储入库，如果发现?findpass则更新密码
    public function persist()
    {
        $request = $this->request->all();
        $authCode = $request['authCode'];
        $mobile = $request['mobile'];
        if (\Cache::get($mobile)!=$authCode) {
            return response()->json(['result' => ['您输入的验证码不正确']], 403);
        }
        if (isset($_GET['findpass'])) {
            return $this->updatePassword();
        } else {
            return $this->register();
        }
    }

    private function register()
    {
        $request = $this->request->all();
        try {
            if ($this->user->has('mobile', $request['mobile'])) {
                return response()->json(['result' => ['该手机号已经注册，请直接登陆']], 403);
            } 
        } catch (Exception $e) {
                return response()->json(['result' => [$e]], 500);
        }

        return $this->user->registerUser($request); //调用 UserRepo方法
    }

    private function updatePassword()
    {
        $request = $this->request->all();

        try {
            if (! $this->user->has('mobile', $request['mobile'])) {
                return response()->json(['result' => ['该手机号没有注册，请返回注册']], 403);
            }
        } catch (Exception $e) {
                return response()->json(['result' => [$e]], 500);
        }
        $this->user->updatePassword($request); //调用 UserRepo方法
        return response()->json(['result' => ['密码修改成功，请重新登陆']], 200);
    }
}