<?php

namespace App\Policies;

use App\Models\Moment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MomentPolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @param Moment $moment
     * @return bool
     */
    public function like(User $user, Moment $moment)
    {
        return !$user->isAuthSelf($moment);
    }
}
