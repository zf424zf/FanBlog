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
    <div class="container container-body">
        @include('layouts._message')
        @yield('content')
    </div>
    @include('layouts._footer')
</div>

<script src="{{static_file('js/app.js')}}"></script>
@yield('scripts')
<script src="http://res2.wx.qq.com/open/js/jweixin-1.4.0.js"></script>
<script>
    $(function () {
        $.ajax({
            type: "GET",
            url: "/wx_config",
            data: {url: this.location.href},
            dataType: "json",
            success: function (data) {
                wx.config({
                    debug: false, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
                    appId: data.appid, // 必填，公众号的唯一标识
                    timestamp: data.timestamp, // 必填，生成签名的时间戳
                    nonceStr: data.nonceStr, // 必填，生成签名的随机串
                    signature: data.signature,// 必填，签名，见附录1
                    jsApiList: ['checkJsApi',
                        'onMenuShareTimeline',
                        'onMenuShareAppMessage',
                        'onMenuShareQQ',
                        'onMenuShareWeibo',
                        'hideMenuItems',
                        'showMenuItems',
                        'hideAllNonBaseMenuItem',
                        'showAllNonBaseMenuItem',
                        'translateVoice',
                        'startRecord',
                        'stopRecord',
                        'onRecordEnd',
                        'playVoice',
                        'pauseVoice',
                        'stopVoice',
                        'uploadVoice',
                        'downloadVoice',
                        'chooseImage',
                        'previewImage',
                        'uploadImage',
                        'downloadImage',
                        'getNetworkType',
                        'openLocation',
                        'getLocation',
                        'hideOptionMenu',
                        'showOptionMenu',
                        'closeWindow',
                        'scanQRCode',
                        'chooseWXPay',
                        'openProductSpecificView',
                        'addCard',
                        'chooseCard',
                        'openCard'] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
                });
                wx.ready(function () {
                    wx.onMenuShareAppMessage({
                        title: "@yield('title', '馒头毛毛球') - {{ setting('site_name', '修炼地') }}", // 分享标题
                        desc: "@yield('title', '馒头毛毛球')", // 分享描述
                        link: window.location.href, // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
                        imgUrl: 'https://ricefur.oss-cn-beijing.aliyuncs.com/ricefur/bbs/upload/images/avatars/11_1538129807_WEVo4xZjiH.jpg?x-oss-process=image/resize,m_lfit,h_362,w_362', // 分享图标
                        type: 'link', // 分享类型,music、video或link，不填默认为link
                        dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
                        success: function () {
                            alert('分享成功')
                        }
                    });
                });

                wx.error(function (res) {
                    alert("error: " + res.errMsg);
                });
            },
            error: function () {
                alert(error);
            }
        })
    })
</script>
</body>
</html>