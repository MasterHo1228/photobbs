<?php

namespace App\Observers;

use Illuminate\Support\Facades\DB;

use App\Models\Topic;
use App\Jobs\TranslateTopicSlug;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class TopicObserver
{
    public function saving(Topic $topic){
        //XSS attack filter
        $topic->body = clean($topic->body, 'user_topic_body');

        $topic->excerpt = make_excerpt($topic->body);
    }

    public function saved(Topic $topic){
        //非命令行环境运行才执行操作
        if (! app()->runningInConsole()){
            //如 slug 字段无内容，即使用翻译器对 title 进行翻译
            if ( ! $topic->slug) {
                // 推送任务到队列
                dispatch(new TranslateTopicSlug($topic));
            }
        }
    }

    public function deleted(Topic $topic)
    {
        DB::table('replies')->where('topic_id', $topic->id)->delete();
    }
}
