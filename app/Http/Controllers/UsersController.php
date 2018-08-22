<?php

namespace App\Http\Controllers;

use App\Handlers\ImageUploadHandler;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;

class UsersController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['show','validateRegToken']]);
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $this->authorize('update', $user);
        return view('users.edit', compact('user'));
    }

    public function update(UserRequest $request, ImageUploadHandler $uploader, User $user)
    {
        $this->authorize('update', $user);
        $data = $request->all();
        //处理头像
        if ($request->avatar) {
            $saveImgResult = $uploader->save($request->avatar, 'avatars', $user->id, 362);
            if ($saveImgResult) {
                //覆盖avatar参数为剪切好的绝对路径
                $data['avatar'] = $saveImgResult['path'];
            }
        }
        $user->update($data);
        return redirect()->route('users.show', $user->id)->with('success', '个人资料更新成功！');
    }

    public function validateRegToken($token)
    {
        $userModel = app(User::class);
        $cacheKey = $userModel->cacheRegKey . $token;
        $tokenArr = \Cache::get($cacheKey);
        if (!empty($tokenArr) && array_key_exists('uid', $tokenArr)) {
            $user = User::find($tokenArr['uid']);
            if ($user) {
                $user->status = $userModel->passUser;
                $user->save();
                \Cache::forget($cacheKey);
                \Auth::login($user);
                return redirect()->route('root')->with('success','恭喜您账号验证成功,开始您的FanBBS之旅吧！');
            }
        }
        return redirect()->route('login')->with('danger','验证信息不存在');
    }

}
