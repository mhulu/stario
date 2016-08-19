@extends('icenter::layouts.authmaster')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 col-sm-6 col-xs-12 col-lg-4 col-md-offset-3 col-lg-offset-4 col-sm-offset-3 header padding-top-20 center  login">
        <img src="http://7lrzqf.com1.z0.glb.clouddn.com/images/ucenter-logo.png">
        <h5>微脉事 WeMesh&trade;</h5> 
        <div class="login-tab row margin-top-20">
            <div class="col-sm-12">
                <div class="col-sm-6 tab"><a href="{{ url('/login') }}">用户登陆</a></div>
                <div class="col-sm-6 tab active">用户注册</div>
            </div>
        </div>
                    <!-- 注册用户 -->
        <form class="form-horizontal" role="form" method="POST" action="{{url('/register')}}">
        {!! csrf_field() !!}
         <div class="form-group {{ $errors->has('mobile') ? 'has-error' : ''}}">
          <label class="col-sm-3 control-label">
          手机号码
          </label>
          <div class="col-sm-9">
            <input type="text"  placeholder=" 输入手机号" value="{{old('mobile')}}" name="mobile" required class="form-control">
            @if ($errors->has('mobile'))
            <span class="help-block">
                <strong>{{ $errors->first('mobile') }}</strong>
            </span>
            @endif
          </div>
        </div>

        <div class="form-group">
          <label class="col-sm-3 control-label">
          短信验证
          </label>
          <div class="col-sm-4">
            <input type="text"  placeholder=" 输入验证码" name="authCode" required class="form-control">
          </div>
          <div class="col-sm-5">
            <count-down @click.prevent="validateMobile" :disabled="notMobile"></count-down>
          </div>
        </div>

        <div class="form-group">
          <label class="col-sm-3 control-label">
          输入密码
          </label>
          <div class="col-sm-9">
             <input type="password"  class="form-control" placeholder=" 输入您的密码" name="password" v-model="credentials.newPassword" required>
          </div>
        </div>

                <div class="form-group">
          <label class="col-sm-3 control-label">
          密码确认
          </label>
          <div class="col-sm-9">
             <input type="password"  class="form-control" placeholder=" 再次输入您的密码" v-model="credentials.rePassword"  required>
          </div>
        </div>
        <button class="btn btn-light-blue btn-lg btn-block margin-bottom-10" @click.stop.prevent="signup"><i class="fa fa-sign-in"></i> 注册</button>
     </form>
        </div>
    </div>
</div>
@endsection
