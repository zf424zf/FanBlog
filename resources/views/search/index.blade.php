@extends('layouts.main')
@section('title','搜索')
@section('scripts')
    <script src="{{static_file('js/jquery.highlight.js')}}"></script>
    <script>
        $(function () {
            let query = "{{$query}}"
            let results = query.match(/("[^"]+"|[^"\s]+)/g);
            results.forEach(function (entry) {
                $('.search-results').highlight(entry);
            });
        })
    </script>
@stop
@section('content')
    <div class="panel panel-default search-results">
        <div class="panel-heading">
            <h3 class="panel-title">以下展示全局的搜索 {{count($result)}} 条：</h3>
        </div>
        <div class="panel-body">
            @foreach($result as $item)
                <div class="result">
                    <h2 class="title">
                        <a href="{{route('topics.show',$item['id'])}}">{{$item->title}}</a>
                        <small>来自</small>
                        <a href="{{route('users.show',$item['users']['id'])}}">
                            <img class="avatar avatar-small" alt="zgldh"
                                 src="{{$item['users']['avatar']}}">
                            <small>{{$item['users']['name']}}</small>
                        </a>
                    </h2>
                    <div class="desc">
                        {!! str_limit(strip_tags($item->body),250) !!}
                    </div>
                    <hr>
                </div>
            @endforeach
            {{$result->appends(Request::except('page'))->links()}}
        </div>
        <div class="panel-footer"></div>
    </div>
@stop