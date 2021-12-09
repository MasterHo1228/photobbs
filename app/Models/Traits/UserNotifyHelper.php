<?php

namespace App\Models\Traits;
use Illuminate\Support\Facades\Auth;

trait UserNotifyHelper
{
    public function topicNotify($instance)
    {
        // 如果要通知的人是当前用户，就不必通知了！
        if ($this->isCurrentUser(Auth::id())) {
            return;
        }

        if (method_exists($instance, 'toDatabase')) {
            $this->increment('notification_count');
        }

        $this->laravelNotify($instance);
    }

    //判断是否为当前用户
    protected function isCurrentUser($user_id){
        return $this->id == $user_id;
    }
}
