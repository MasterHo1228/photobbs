<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reply extends Model
{
    use HasFactory;
    // 开启软删除
    //use SoftDeletes;

    // 设置添加的数据
    // 拒绝不添加的数据 使用create才有效
    protected $guarded = [];

    // 软删除标识字段
    protected $dates = ['deleted_at'];

    protected $fillable = ['content'];

    public function topic(){
        return $this->belongsTo(Topic::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function mentionedUsers()
    {
        preg_match_all('/@([\w\-]+)/', $this->content, $matches);
        return $matches[1];
    }
}
