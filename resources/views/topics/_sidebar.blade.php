@if(isset($newTopic))
    <div class="panel panel-default">
        <div class="panel-body">
            <a href="{{ route('topics.create') }}" class="btn btn-success btn-block" aria-label="Left Align">
                <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> 新建帖子
            </a>
        </div>
    </div>
@endif
@if(isset($newMoments))
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="text-center">最新吐槽</div>
            <hr>
            @foreach($newMoments as $moment)
                <div class="media" style="display:table">
                    <div class="media-left">
                        <a href="{{route('users.show',['id'=>$moment->user_id])}}">
                            <img alt="64x64" class="media-object img-thumbnail avatar avatar-middle"
                                 data-src="holder.js/64x64" style="width: 26px;height: 26px;padding:0px;"
                                 src="{{$moment->user->avatar}}"
                                 data-holder-rendered="true">
                        </a>
                    </div>
                    <div class="media-body" style="display:table;width:100%;table-layout:fixed">
                        <div class="media-body markdown-reply content-body"
                             style="display:block;width:100%;font-size: 14px;">
                            <a href="{{route('users.show',$moment->user->id)}}"
                               class="rm-link-color">{{$moment->user->name}}</a>：<span
                                    class="rm-link-color clickable">{!!$moment['content']!!}</span>
                        </div>
                    </div>
                </div>
            @endforeach
            <div class="text-center">
                <a href="{{route('moment.index')}}"
                   style="color:#999;font-size:0.9em;margin-top: 12px;display: inline-block;">更多吐槽</a>
            </div>
        </div>
    </div>
@endif
@if (count($active_users))
    <div class="panel panel-default">
        <div class="panel-body active-users">

            <div class="text-center">活跃用户</div>
            <hr>
            @foreach ($active_users as $active_user)
                <a class="media" href="{{ route('users.show', $active_user->id) }}">
                    <div class="media-left media-middle">
                        <img src="{{ $active_user->avatar }}" width="24px" height="24px"
                             class="img-circle media-object">
                    </div>

                    <div class="media-body">
                        <span class="media-heading">{{ $active_user->name }}</span>
                    </div>
                </a>
            @endforeach

        </div>
    </div>
@endif

@if (count($links))
    <div class="panel panel-default">
        <div class="panel-body active-users">

            <div class="text-center">文章推荐</div>
            <hr>
            @foreach ($links as $link)
                <a class="media" href="{{ $link->link }}">
                    <div class="media-body">
                        <span class="media-heading">{{ $link->title }}</span>
                    </div>
                </a>
            @endforeach

        </div>
    </div>
@endif