<?php

namespace App\Http\Controllers;

use App\Handlers\ImageUploadHandler;
use App\Models\Category;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TopicRequest;
use App\Models\Link;

class TopicsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show', 'search']]);
    }

    public function index(Request $request, Topic $topic, User $user, Link $link)
    {
        $topics = $topic->withOrder($request->order)->paginate(20);
        //获取活跃用户
        $active_users = $user->getActiveUsers();
        //获取推荐资源列表
        $links = $link->getAllCache();
        $newTopic = true;
        return view('topics.index', compact('topics', 'active_users', 'links', 'newTopic'));
    }

    public function show(Request $request, Topic $topic)
    {
        //topic字段不为空的情况下强制跳转
        if (!empty($topic->slug) && $topic->slug != $request->slug) {
            return redirect($topic->link(), 301);
        }
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
        return redirect()->to($topic->link())->with('message', '帖子创建成功');
    }

    public function edit(Topic $topic)
    {
        $this->authorize('update', $topic);
        $categories = Category::all();
        return view('topics.create_and_edit', compact('topic', 'categories'));
    }

    public function update(TopicRequest $request, Topic $topic)
    {
        $this->authorize('update', $topic);
        $topic->update($request->all());

        return redirect()->to($topic->link())->with('message', '帖子更新成功');
    }

    public function destroy(Topic $topic)
    {
        //权限验证
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
            $imageInfo = $handler->saveTest($file, $request->get('type', 'topics'), \Auth::id(), 1024);
            if ($imageInfo) {
                $data['success'] = true;
                $data['msg'] = "上传成功!";
                $data['file_path'] = $imageInfo['path'];
            }
        }
        return $data;
    }

    public function search(Request $request, Topic $topic)
    {
          $result = $topic->search(htmlspecialchars_decode($request->get('q')))->paginate(15);
          $uids = collect($result->items())->pluck('user_id')->toArray();
          $users = User::whereIn('id',$uids)->get(['id','name','avatar'])->keyBy('id')->toArray();
          foreach ($result as $item){
              if(array_key_exists($item['user_id'],$users)){
                  $item['users'] = $users[$item['user_id']];
              }
          }
          $query = htmlspecialchars_decode($request->get('q'));
          return view('search.index', compact('result', 'query'));
    }
}
