<?php

namespace App\Http\Controllers\Api;


use App\Http\Requests\Api\TopicRequest;
use App\Models\Topic;
use App\Transformers\TopicTransformer;

class TopicsController extends Controller
{
    //
    public function store(TopicRequest $request, Topic $topic)
    {
        //批量赋值
        $topic->fill($request->all());
        $topic->user_id = $this->user()->id;
        $topic->save();

        return $this->response->item($topic, app(TopicTransformer::class))->setStatusCode(201);
    }
}
