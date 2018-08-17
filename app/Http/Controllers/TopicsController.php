<?php

namespace App\Http\Controllers;

use App\Handlers\ImageUploadHandler;
use App\Models\Category;
use App\Models\Topic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TopicRequest;

class TopicsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    public function index(Request $request, Topic $topic)
    {
        //使用预加载
        $topics = $topic->withOrder($request->order)->paginate(30);
        return view('topics.index', compact('topics'));
    }

    public function show(Topic $topic)
    {
        return view('topics.show', compact('topic'));
    }

    public function create(Topic $topic)
    {
        //获取所有分类
        $categories = Category::all();
        return view('topics.create_and_edit', compact('topic', 'categories'));
    }

    public function store(TopicRequest $request, Topic $topic)
    {
        //获取request属性拼接到model
        $topic->fill($request->all());
        //设置帖子用户id为当前用户id
        $topic->user_id = \Auth::id();
        $topic->save();
        //跳转到帖子详情页面
        return redirect()->route('topics.show', $topic->id)->with('message', '帖子创建成功');
    }

    public function edit(Topic $topic)
    {
        $this->authorize('update', $topic);
        return view('topics.create_and_edit', compact('topic'));
    }

    public function update(TopicRequest $request, Topic $topic)
    {
        $this->authorize('update', $topic);
        $topic->update($request->all());

        return redirect()->route('topics.show', $topic->id)->with('message','帖子更新成功');
    }

    public function destroy(Topic $topic)
    {
        $this->authorize('destroy', $topic);
        $topic->delete();

        return redirect()->route('topics.index')->with('message', '帖子删除成功');
    }

    public function uploadImage(Request $request, ImageUploadHandler $handler)
    {
        // 初始化返回
        $data = [
            'success' => false,
            'msg' => '上传失败!',
            'file_path' => ''
        ];

        if ($file = $request->upload_file) {
            //保存图片获取图片信息
            $imageInfo = $handler->save($file, 'topics', \Auth::id(), 1024);
            if ($imageInfo) {
                $data['success'] = true;
                $data['msg'] = "上传成功!";
                $data['file_path'] = $imageInfo['path'];
            }
        }
        return $data;
    }
}