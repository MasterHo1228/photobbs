<?php

namespace App\Observers;

use App\Models\Reply;
use App\Notifications\TopicReplied;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class ReplyObserver
{
    public function creating(Reply $reply){
        // XSS filter
        $reply->content = clean($reply->content, 'user_topic_body');
        // 判断内容为空的处理方式，拒绝保存入库
        if ($reply->content === '') {
            return false;
        }
    }

    public function created(Reply $reply)
    {
        $reply->topic->updateReplyCount();
        //非命令行环境运行才执行操作
        if (! app()->runningInConsole()){
            $reply->topic->user->topicNotify(new TopicReplied($reply));
        }
    }

    public function deleted(Reply $reply){
        $reply->topic->updateReplyCount();
    }
}
