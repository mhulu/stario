<?php

namespace Star\Icenter\Forms;

use App\Http\Requests\Request;
use Star\Icenter\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Star\Icenter\Repos\Eloquent\UserRepo;

class UserInfoRequest extends FormRequest
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
            'name' => 'required | min:2 | max:15',
            'mobile' => 'required'
        ];
    }

    // 存储入库，如果发现?findpass则更新密码
    public function persist()
    {
        return $this->update();
    }

    private function update()
    {
        $request = $this->request->all();

        try {
            if (! $this->user->has('mobile', $request['mobile'])) {
                return response()->json(['result' => ['该手机号没有注册，请返回注册']], 403);
            }
        } catch (Exception $e) {
                return response()->json(['result' => [$e]], 500);
        }
    }
}