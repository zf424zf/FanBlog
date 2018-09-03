@extends('layouts.main')
@section('title','吐槽吧')
@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/simditor.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/simditor-emoji.css') }}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/iconfont.css')}}">
@stop

@section('scripts')
    <script type="text/javascript" src="{{ asset('js/module.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/hotkeys.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/uploader.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/simditor.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/simditor-emoji.js') }}"></script>
    <script>
        $(document).ready(function () {
            let editor = new Simditor({
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
            editor.on('valuechanged ', function (e) {
                let length = $(this.getValue()).text().length;
                if (length >= 120) {
                    return false
                }
                $('#content-count').html(length)
            });
            let likeActive = false;
            $(document).on('click', '.operate-vote', function () {
                let self = $(this)
                if (!likeActive) {
                    likeActive = true;
                    $.ajax({
                        type: self.data('type'),
                        url: self.data('url'),
                        data: {type: 2, sid: self.data('id'), _token: "{{csrf_token()}}"},
                        success: function (res) {
                            let span = self.parent().find('.like_cnt')
                            let newLike = 0
                            if (res.like_status == 1) {
                                newLike = span.data('num') + 1;
                                span.html(newLike);
                                span.data('num', newLike)
                            } else {
                                newLike = span.data('num') - 1;
                                span.html(newLike);
                                span.data('num', newLike)
                            }
                            if (self.hasClass('active')) {
                                self.removeClass('active')
                            } else {
                                self.addClass('active')
                            }
                            console.log(span.data('num'))
                            likeActive = false;
                        },
                        error: function (res) {
                            if (res.status == 401) {
                                location.href = '/login';
                            } else if (res.status == 403) {
                                alert('不能给自己点赞')
                            }
                            likeActive = false;
                        }
                    })
                }

            });
        });
    </script>

@stop
@section('content')
    <div class="row">
        <div class="col-lg-9 col-md-9 moment-list">
            <div class="panel">
                <form action="{{route('moment.store')}}" METHOD="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                    <textarea name="content" class="form-control" id="editor" rows="3"
                              placeholder="吐槽吧,骚年!"
                              required>
                    </textarea>
                    </div>
                    <div class="form-group clearfix">
                        <div class="pull-right">
                            <span style="padding-right: 10px"><span id="content-count">0</span>/120</span>
                            <button type="submit" class="btn btn-primary btn-sm ">发布</button>
                        </div>
                    </div>
                </form>
            </div>
            <ul class="list-group">
                @foreach($data as $item)
                    <li class="list-group-item clearfix">
                        <div class="pull-left">
                            <a href="">
                                <img height="48px" width="48px" style="border-radius: 48px;border: 1px #1dc5a3 solid"
                                     src="{{$item->user->avatar}}"
                                     alt="">
                            </a>
                        </div>
                        <div class="moment-info">
                            <div class="moment-user">
                                <a href=""><strong>{{$item['user']['name']}}</strong></a>
                                <span class="meta">{{$item->created_at->diffForHumans()}}</span>
                            </div>
                            <div class="moment-body">
                                <div class="moment-content">{!! $item->content !!}</div>
                                <div class="operate">
                                    <a class="operate-vote @if(count($item['like']) > 0) active @endif"
                                       href="javascript:void(0)" data-id="{{$item['id']}}"
                                       data-url="{{route('like')}}"
                                       data-type="POST">
                                        <i class="iconfont">&#xe657;</i>
                                    </a>
                                    <span class="like_cnt" data-num= {{$item->like_cnt}}>{{$item->like_cnt}}</span>
                                </div>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
            {!! $data->appends(Request::except('page'))->render() !!}
        </div>
        <div class="col-lg-3 col-md-3 sidebar">
            @include('topics._sidebar')
        </div>
    </div>
@stop