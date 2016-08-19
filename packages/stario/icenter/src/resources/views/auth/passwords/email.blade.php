@extends('layouts.authmaster')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 col-sm-6 col-xs-12 col-lg-4 col-md-offset-3 col-lg-offset-4 col-sm-offset-3 header padding-top-20 center  login">
        <img src="http://7lrzqf.com1.z0.glb.clouddn.com/images/ucenter-logo.png">
        <h5>微脉事 WeMesh&trade;</h5> 
        <div class="login-tab row margin-top-20">
          <h3><i class="fa fa-life-ring"></i> 找回密码</h3>
        </div>
            <findpass></findpass>
        </div>
    </div>
</div>
@endsection
