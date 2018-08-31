@extends('layouts.main')
@section('title','吐槽吧')
@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/simditor.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/simditor-emoji.css') }}">
@stop

@section('scripts')
    <script type="text/javascript" src="{{ asset('js/module.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/hotkeys.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/uploader.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/simditor.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/simditor-emoji.js') }}"></script>
    <script>
        $(document).ready(function () {
            var editor = new Simditor({
                textarea: $('#editor'),
                toolbar: [
                    'image',
                    'emoji'
                ],
                upload: {
                    url: '{{route('topics.upload_image')}}',
                    params: {_token: '{{ csrf_token() }}', type: 'moments'},//POST请求必须带防止CSRF跨站请求伪造的_token 参数；
                    fileKey: 'upload_file',//服务器端获取图片的键值
                    connectionCount: 2,// 最多只能同时上传2张图片；
                    leaveConfirm: '文件正在上传中，关闭页面则会取消上传'
                },
                emoji: {
                    imagePath: '{{ '/upload/images/emoji'}}'
                },
                pasteImage: true//是否支持图片黏贴上传
            });
            console.log(editor)
        });
    </script>

@stop
@section('content')
    <div class="row">
        <div class="col-lg-9 col-md-9 moment-list">
            <div class="panel">
                <div class="form-group">
                    <textarea name="body" class="form-control" id="editor" rows="3"
                              placeholder="请填入至少三个字符的内容。"
                              required>
                    </textarea>
                </div>
                <div class="form-group clearfix">
                    <div class="pull-right">
                        <span style="padding-right: 10px"><span id="content-count">0</span>/120</span>
                        <button class="btn btn-primary btn-sm ">发布</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop