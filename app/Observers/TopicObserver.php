<?php

namespace App\Observers;

use App\Handlers\SlugTranslateHandler;
use App\Jobs\TranslateSlug;
use App\Models\Topic;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class TopicObserver
{
    public function creating(Topic $topic)
    {
        //
    }

    public function updating(Topic $topic)
    {
        //
    }

    public function saving(Topic $topic)
    {
        //防止xss攻击 进行过滤
        $topic->body = clean($topic->body, 'user_topic_body');

        //根据文章体生成摘录
        $topic->excerpt = make_excerpt($topic->body);


    }

    public function saved(Topic $topic){
        //如果slug为空 则对title进行翻译 seo处理
        if (!$topic->slug) {
            dispatch(new TranslateSlug($topic));
        }
    }
}