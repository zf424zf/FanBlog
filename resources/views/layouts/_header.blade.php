@section('scripts')
    <script>
        $(function () {
            $('.dropdown').mouseover(function () {
                $(this).addClass('open')
            })

            $('.dropdown').mouseout(function () {
                $(this).removeClass('open')
            })
        })
    </script>
@endsection
<nav class="navbar navbar-default navbar-static-top">
    <div class="container">
        <div class="navbar-header">

            <!-- Collapsed Hamburger -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#app-navbar-collapse">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <!-- Branding Image -->
            <a class="navbar-brand" href="{{ url('/') }}">
                {{config('app.name')}}
            </a>
        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <!-- Left Side Of Navbar -->
            <ul class="nav navbar-nav">
                @foreach($menus as $menu)
                    <li class="@if(isset($menu['son']))dropdown @endif {{ active_class(if_uri($menu['url'])) }}">
                        <a class="@if(isset($menu['son']))dropdown-toggle @endif"
                           href="{{ $menu['url'] }}">{{$menu['name']}}
                            @if(isset($menu['son']))<b class="caret"></b>@endif
                        </a>
                        @if(isset($menu['son']))
                            <ul class="dropdown-menu">
                                @foreach($menu['son'] as $item)
                                    <li>
                                        <a href="{{$item['url']}}">{{$item['name']}}</a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endforeach
                {{--<li class="{{ active_class(if_route('topics.index')) }}"><a href="{{ route('topics.index') }}">话题</a></li>--}}
                {{--@foreach($categoriesList as $category)--}}
                {{--<li class="{{active_class(if_route('categories.show') && if_route_param('category', $category['id']))}}">--}}
                {{--<a href="{{ route('categories.show', $category['id']) }}">{{$category['name']}}</a>--}}
                {{--</li>--}}
                {{--@endforeach--}}
            </ul>
            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <form method="GET" action="{{route('topic.search')}}" accept-charset="UTF-8" id="search" class="navbar-form navbar-left ">
                    <div class="form-group">
                        <input class="form-control search-input mac-style" placeholder="搜索文章" name="q" type="text" value="">
                    </div>
                </form>
                <!-- Authentication Links -->
                @guest
                    <li><a href="{{ route('login') }}">登录</a></li>
                    <li><a href="{{ route('register') }}">注册</a></li>
                @else
                    <li>
                        <a href="{{ route('topics.create') }}">
                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        </a>
                    </li>
                    {{-- 消息通知标记 --}}
                    <li>
                        <a href="{{ route('notifications.index') }}" class="notifications-badge"
                           style="margin-top: -2px;">
                            <span class="badge badge-{{ Auth::user()->notification_count > 0 ? 'hint' : 'fade' }} "
                                  title="消息提醒">
                                {{ Auth::user()->notification_count }}
                            </span>
                        </a>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            <span class="user-avatar pull-left" style="margin-right:8px; margin-top:-5px;">
                                <img src="{{Auth::user()->avatar}}" class="img-responsive img-circle" width="30px"
                                     height="30px">
                            </span>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            @can('manage_contents')
                                <li>
                                    <a href="{{ url(config('administrator.uri')) }}">
                                        <span class="glyphicon glyphicon-dashboard" aria-hidden="true"></span>
                                        管理后台
                                    </a>
                                </li>
                            @endcan
                            <li>
                                <a href="{{route('users.show',Auth::id())}}">
                                    <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                                    个人中心
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('users.edit', Auth::id()) }}">
                                    <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                                    编辑资料
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                    <span class="glyphicon glyphicon-log-out" aria-hidden="true"></span>
                                    退出登录
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                      style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>