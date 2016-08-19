<!DOCTYPE html>
<html class="overlay_open">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="author" content="staraw">
  <meta name="description" content="世达奥科">
 <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black">
  <meta id="token" name="token" content="{{ csrf_token() }}">
  <title>微脉事WeMesh&trade;</title>
  <link rel="stylesheet" type="text/css" href="http://cdn.bootcss.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <link href="http://cdn.bootcss.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet">
  <link href="http://cdn.bootcss.com/jquery.perfect-scrollbar/0.6.10/css/perfect-scrollbar.min.css" rel="stylesheet">
  <link href="http://cdn.bootcss.com/sweetalert/1.1.3/sweetalert.min.css" rel="stylesheet">
  <link rel="shortcut icon" href="{{asset('favicon.ico')}}" />
  <link href={{asset('assets/css/app.css')}} rel=stylesheet>
</head>
<body>
<!--[if lt IE 10]>
<p class="browserupgrade">您的浏览器已<strong>面临淘汰</strong>,到这里<a href="http://www.stario.net/bye.html/">升级靠谱浏览器</a>提升安全及体验。</p>
<![endif]-->
  <div class="overlay vcenter">
    <div class="overlay_mask"></div>
    <div class="overlay_content">
      @yield('content')
    </div>
  </div>
</body>