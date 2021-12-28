<?php

namespace App\Models;

use App\Models\Traits\UserNotifyHelper;
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
use Overtrue\LaravelFollow\Followable;

class User extends Authenticatable implements MustVerifyEmailContract
{
    use HasApiTokens, HasFactory, HasRoles, MustVerifyEmailTrait;
    use Notifiable {
        notify as protected laravelNotify;
    }
    use Followable;

    use Traits\ActiveUserHelper;
    use Traits\LastActivedAtHelper;
    use Traits\UserNotifyHelper;
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
        'nickname',
        'email',
        'phone',
        'password',
        'introduction',
        'avatar',
        'weixin_openid',
        'weixin_unionid',
        'registration_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'weixin_openid',
        'weixin_unionid'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function setPasswordAttribute($value){
        if(empty($value)){
            return;
        }

        // 如果值的长度等于 60，即认为是已经做过加密的情况
        if (strlen($value) != 60) {
            // 不等于 60，做密码加密处理
            $value = bcrypt($value);
        }

        $this->attributes['password'] = $value;
    }

    /**
    * 访问器-头像链接字段
    * @param string $value
    * @return string
    */
    public function getAvatarAttribute($value)
    {
        //用户确实没有头像的话，使用默认头像
        if (empty($value)) {
            return 'https://cdn.learnku.com/uploads/images/201710/30/1/TrJS40Ey5k.png';
        }
        return $value;
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

    public function getNickNameAttribute($value){
        //用户没有设置昵称的话，返回账户的用户名
        if (empty($value)) {
            return $this->name;
        }
        return $value;
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

    public function markAsRead(){
        $this->notification_count = 0;
        $this->save();
        $this->unreadNotifications->markAsRead();
    }
}
