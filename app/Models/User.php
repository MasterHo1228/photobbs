<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Auth\MustVerifyEmail as MustVerifyEmailTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Str;

class User extends Authenticatable implements MustVerifyEmailContract
{
    use HasApiTokens, HasFactory, HasRoles, MustVerifyEmailTrait, Notifiable;
    use Traits\ActiveUserHelper;
    use Traits\LastActivedAtHelper;
    // 开启软删除
    //use SoftDeletes;

    // 设置添加的数据
    // 拒绝不添加的数据 使用create才有效
    protected $guarded = [];

    // 软删除标识字段
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'introduction',
        'avatar',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
    * 访问器-头像链接字段
    * @param string $value
    * @return string
    */
    public function getAvatarAttribute($value)
    {
        if (empty($value)) {
            return 'https://cdn.learnku.com/uploads/images/201709/20/1/PtDKbASVcz.png?imageView2/1/w/600/h/60';
        }
        return $value;
    }

    public function setPasswordAttribute($value){
        // 如果值的长度等于 60，即认为是已经做过加密的情况
        if (strlen($value) != 60) {
            // 不等于 60，做密码加密处理
            $value = bcrypt($value);
        }

        $this->attributes['password'] = $value;
    }

    public function setAvatarAttribute($path)
    {
        // 如果不是 `http` 子串开头，那就是从后台上传的，需要补全 URL
        if ( ! Str::startsWith($path, 'http')) {

            // 拼接完整的 URL
            $path = config('app.url') . "/uploads/images/avatars/$path";
        }

        $this->attributes['avatar'] = $path;
    }

    public function topics(){
        return $this->hasMany(Topic::class);
    }

    public function replies(){
        return $this->hasMany(Reply::class);
    }

    public function isAuthorOf($model){
        return $this->id == $model->user_id;
    }

    public function topicNotify($instance)
    {
        // 如果要通知的人是当前用户，就不必通知了！
        if ($this->id == Auth::id()) {
            return;
        }

        if (method_exists($instance, 'toDatabase')) {
            $this->increment('notification_count');
        }

        $this->notify($instance);
    }

    public function markAsRead(){
        $this->notification_count = 0;
        $this->save();
        $this->unreadNotifications->markAsRead();
    }
}
