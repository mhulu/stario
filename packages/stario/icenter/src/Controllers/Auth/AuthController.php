<?php

namespace Star\Icenter\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use JWTAuth;
use Star\Icenter\Events\LoginEvent;
use Star\Icenter\User;

class AuthController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('jwt.auth', ['except' => ['login']]);
    // }

    public function register(Request $request)
    {
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        User::create($input);
        return response()->json([
          'code' => 200,
          'result' => true
          ]);
    }
    
    public function login(Request $request)
    {
           $credentials = $request->only('mobile', 'password');
        try {
            // verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['result' => '手机号或密码错误'], 403);
            }
        } catch (JWTException $e) {
            // something went wrong
            return response()->json(['result' => '服务器内部错误'], 500);
        }
        // if no errors are encountered we can return a JWT
        Event::fire(new LoginEvent(User::find(Auth::user()->id)));
         return response()->json([
          'result' => [
          	'id' => Auth::user()->id,
          	'token' => $token
          ]
          ], 200);
    }

    public function refreshToken(Request $request)
    {
        $token = $request->header('Authorization');
        return response()->json([
            'result' => JWTAuth::refresh(str_replace('Bearer ', '', $token))
            ], 200);
    }
}