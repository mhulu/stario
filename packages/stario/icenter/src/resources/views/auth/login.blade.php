@extends('icenter::layouts.authmaster')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 col-sm-6 col-xs-12 col-lg-4 col-md-offset-3 col-lg-offset-4 col-sm-offset-3 header padding-top-20 center  login">
        <img src="http://7lrzqf.com1.z0.glb.clouddn.com/images/ucenter-logo.png">
        <h5>微脉事 WeMesh&trade;</h5> 
        <div class="login-tab row margin-top-20">
            <div class="col-sm-12">
                <div class="col-sm-6 tab active">用户登陆</div>
                <div class="col-sm-6 tab"><a href="{{ url('/register') }}">用户注册</a></div>
            </div>
        </div>
        <div class="form">
            <form role="form" method="POST" action="{{ url('/login') }}" >
                 {!! csrf_field() !!}
                 <div class="form-group{{ $errors->has('mobile') ? ' has-error' : '' }}">
                     <div class="input-group">
                         <div class="input-group-addon"><i class="fa fa-mobile" style="font-size: 20px;width:14px"></i></div>
                         <input type="text" class="form-control" required placeholder=" 输入手机号" name="mobile" value="{{ old('mobile') }}" >
                     </div>
                     @if ($errors->has('mobile'))
                                    <div class="help-block">
                                        <strong>{{ $errors->first('mobile') }}</strong>
                                    </div>
                        @endif
                 </div>
                 <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                     <div class="input-group">
                         <div class="input-group-addon"><i class="fa fa-key"></i></div>
                         <input type="password" class="form-control" required placeholder=" 输入您的密码" name="password">
                     </div>
                     @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                        @endif
                 </div>
           <div class="row">
           <div class="checkbox clip-check check-primary col-sm-6">
            <input type="checkbox" name="remember" id="remember">
            <label for="remember" class="pull-left margin-left-15">
              两周内免登陆 
            </label>
          </div>
          <div class="col-sm-6">
            <a  href="{{ url('/password/reset') }}" class="pull-right" style="height: 43px;line-height: 43px;">找回密码</a>
          </div>
          </div>
          <button type="submit" class="btn btn-light-blue btn-lg btn-block margin-bottom-10"><i class="fa fa-sign-in"></i> 点击登陆</button>
            </form>
        </div>
        </div>
    </div>
</div>
@endsection
