<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function update(User $currentUser, User $user){
        //不需要检查 $currentUser 是不是 NULL。未登录用户，框架会自动为其 所有权限 返回 false；
        return $currentUser->id === $user->id;
    }
}
