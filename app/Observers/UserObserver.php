<?php

namespace App\Observers;

use App\Handlers\UserHandle;
use App\Models\User;
use App\Notifications\UserReg;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class UserObserver
{
    public function creating(User $user)
    {
        //
    }

    public function created(User $user)
    {
        $user->regNotify(new UserReg($user));
    }

    public function updating(User $user)
    {
        //
    }

    public function saving(User $user)
    {
        if (empty($user->avatar)) {
            $user->avatar = config('app.url') . '/upload/images/avatars/201808/15/1_1534337186_AIhyprQnBU.jpg';
        }
    }
}