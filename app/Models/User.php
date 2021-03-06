<?php

namespace App\Models;
;

use App\Handlers\UserHandle;
use App\Models\Traits\ActiveUserHelper;
use App\Models\Traits\LastActivedHelper;
use App\Models\Traits\UserStatus;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{


    use Notifiable {
        //重命名trait方法
        notify as protected laravelNotify;
    }

    use HasRoles;
    use ActiveUserHelper;
    use LastActivedHelper;
    use UserHandle;
    use UserStatus;

    public function notify($instance)
    {
        if ($this->id == \Auth::id()) {
            return;
        }
        //未读消息+1
        $this->increment('notification_count');
        $this->laravelNotify($instance);
    }

    public function regNotify($instance)
    {
        $this->laravelNotify($instance);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'phone', 'email', 'password', 'introduction', 'avatar', 'weixin_unionid', 'wx_openid'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function topics()
    {
        return $this->hasMany(Topic::class);
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function isAuthSelf($model)
    {
        return $this->id == $model->user_id;
    }

    public function markAsRead()
    {
        $this->notification_count = 0;
        $this->save();
        $this->unreadNotifications->markAsRead();
    }

    public function setPasswordAttribute($value)
    {
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
        if (!starts_with($path, 'http')) {

            // 拼接完整的 URL
            $path = config('app.url') . "/upload/images/avatars/$path";
        }

        $this->attributes['avatar'] = $path;
    }

    // 返回User的id
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    //额外在JWT载荷中增加的自定义内容
    public function getJWTCustomClaims()
    {
        return [];
    }
}
