<?php
/**
 * Created by PhpStorm.
 * User: zf424zf
 * Date: 2018/9/2
 * Time: 20:30
 */

namespace App\Http\Controllers;


use App\Http\Requests\LikeRequest;
use App\Models\Like;
use App\Models\Moment;

class LikeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function like(LikeRequest $request, Like $like)
    {
        if ($request->type == 1) {
            //todo
            $model = null;
        } else {
            $model = Moment::where('id', $request->sid)->first();
        }
        if (!$model) {
            return response('moment not found', 404);
        }
        $this->authorize('like', $model);
        $like = $like->where('user_id', \Auth::id())->where('type', $type = $request->type)->where('sid', $sid = $request->sid)->first();
        if ($like) {
            $like->status = (int)!$like->status;
        } else {
            $like = app(Like::class);
            $like->type = $type;
            $like->sid = $sid;
            $like->status = 1;
            $like->user_id = \Auth::id();
        }
        $like->save();
        return ['status' => 'success', 'like_status' => $like->status];
    }
}