<?php

namespace App\Http\Controllers;

use App\Http\Requests\MomentRequest;
use App\Models\Moment;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Link;

class MomentController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index']]);
    }

    public function index(Request $request, Moment $moment, User $user, Link $link)
    {

        //获取活跃用户
        $active_users = $user->getActiveUsers();
        //获取推荐资源列表
        $links = $link->getAllCache();
        $data = $moment->with('user:id,name,avatar')->orderBy('created_at', 'desc')->paginate(20);
        return view('moment.index', compact('data', 'active_users', 'links'));
    }

    public function store(MomentRequest $request, Moment $moment)
    {
        $moment->fill($request->only('content'));
        $moment->user_id = \Auth::id();
        $moment->save();
        return redirect()->route('moment.index')->with('message', '吐槽成功!');
    }
}
