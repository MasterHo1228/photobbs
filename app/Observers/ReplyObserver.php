<?php

namespace App\Observers;

use App\Models\Reply;
use App\Models\User;
use App\Notifications\TopicReplied;
use App\Notifications\UserMentioned;
use Illuminate\Support\Facades\DB;

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

        // 通知被提及用户
        User::whereIn('name', $reply->mentionedUsers())
            ->get()
            ->each(function ($user) use ($reply) {
                $user->notify(new UserMentioned($reply));
            });
    }

    public function deleted(Reply $reply){
        $reply->topic->updateReplyCount();
    }
}
