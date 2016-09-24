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
            'newMobile' => 'required|max:11',
            'newPassword' => 'required|min:6|confirmed',
            'newPassword_confirmation'=>'required|min:6',
            'authCode' => 'required'
        ];
    }

    // 存储入库，如果发现?findpass则更新密码
    public function persist()
    {
        if (isset($_GET['findpass'])) {
            return $this->updatePassword();
        } else {
            return $this->createUser();
        }
    }

    private function createUser()
    {
        $request = $this->request->all();
        try {
            if ($this->user->has('mobile', $request['newMobile'])) {
                return response()->json(['result' => ['该手机号已经注册，请直接登陆']], 403);
            } elseif ($request['authCode'] !== Cache::get($request['newMobile'])) {
                return response()->json(['result' => ['短信验证码填写错误']], 403);
            }
        } catch (Exception $e) {
                return response()->json(['result' => [$e]], 500);
        }

        return $this->user->createUser($request); //调用 UserRepo方法
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
        $this->user->updateUser($request); //调用 UserRepo方法
        return response()->json(['result' => ['密码重置成功，请重新登陆']], 200);
    }
}