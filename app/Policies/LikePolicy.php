<?php

namespace App\Policies;

use App\Like;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LikePolicy
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

    public function before($user, $ability)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }

    /**
     * Determine if the given user can create like.
     *
     * @param  \App\User  $user
     * @return bool
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine if the given user can delete like.
     *
     * @param  \App\User  $user
     * @param  \App\Like  $like
     * @return bool
     */
    public function delete(User $user, Like $like)
    {
        return $user->id === $like->user_id;
    }
}
