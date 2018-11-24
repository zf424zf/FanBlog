<!DOCTYPE html>
<html lang="{{app()->getLocale()}}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">

    <!-- csrf-token -->
    <meta name="csrf-token" content="{{csrf_token()}}">
    <meta property="og:type" content="website" />
    <meta property="og:title" content="@yield('title', 'FanBBS') - {{ setting('site_name', '修炼地') }}">
    <meta property="og:description" content="大馒头精的博客呀，来看看吧">
    <meta property="og:image" content="https://ricefur.oss-cn-beijing.aliyuncs.com/ricefur/bbs/upload/images/avatars/11_1538129807_WEVo4xZjiH.jpg?x-oss-process=image/resize,m_lfit,h_362,w_362">
    <meta property="og:url" content="http://www.ricefur.cn/">
    <title>@yield('title', 'FanBBS') - {{ setting('site_name', '修炼地') }}</title>
    <meta name="description" content="@yield('description',"大馒头精的技术港")" />
    <!-- styles -->
    <link rel="stylesheet" href="{{static_file('css/app.css')}}">

    @yield('styles')
</head>

<body>
<div id="app" class="{{route_class()}}-page">
    @include('layouts._header')
    <div class="container">
        @include('layouts._message')
        @yield('content')
    </div>
    @include('layouts._footer')
</div>

<script src="{{static_file('js/app.js')}}"></script>
@yield('scripts')
</body>
</html>