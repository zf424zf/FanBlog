<?php
/**
 * Created by PhpStorm.
 * User: zf424zf
 * Date: 2018/9/2
 * Time: 23:19
 */

namespace App\Observers;


use App\Models\Like;

class LikeObserver
{
    public function saved(Like $like)
    {
        if($like->status == 1){
            $like->typem->increment('like_cnt', 1);
        }else{
            $like->typem->decrement('like_cnt', 1);
        }
    }
}