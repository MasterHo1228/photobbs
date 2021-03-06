<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

use App\Models\Topic;
use App\Handlers\SlugHandler;

class TranslateTopicSlug implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $topic;

    public function __construct(Topic $topic)
    {
        // 队列任务构造器中接收了 Eloquent 模型，将会只序列化模型的 ID
        $this->topic = $topic;
    }

    public function handle()
    {
        $title = $this->topic->title;
        if (!ctype_alpha($title)) {
            //非英文 请求翻译 API 接口进行翻译，翻译后生成slug链接后缀
            $slug = app(SlugHandler::class)->generate_with_translate($title);
        } else {
            //否则字符直接转义
            $slug = app(SlugHandler::class)->generate($title);
        }

        // 为了避免模型监控器死循环调用，我们使用 DB 类直接对数据库进行操作
        DB::table('topics')->where('id', $this->topic->id)->update(['slug' => $slug]);
    }
}
