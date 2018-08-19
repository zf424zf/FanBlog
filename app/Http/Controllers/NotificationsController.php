<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        //获取用户所有通知信息
        $notifications = \Auth::user()->notifications()->paginate(20);
        \Auth::user()->markAsRead();
        return view('notifications.index',compact('notifications'));
    }
}
