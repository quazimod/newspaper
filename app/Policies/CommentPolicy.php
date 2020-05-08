<?php

namespace App\Policies;

use App\Comment;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
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
     * Determine if the given user can create comments.
     *
     * @param  \App\User  $user
     * @return bool
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine if the given user can create comments.
     *
     * @param  \App\User  $user
     * @param  \App\Comment  $comment
     * @return bool
     */
    public function update(User $user, Comment $comment)
    {
        return $user->id === $comment->user_id;
    }

    /**
     * Determine if the given user can create comments.
     *
     * @param  \App\User  $user
     * @param  \App\Comment  $comment
     * @return bool
     */
    public function delete(User $user, Comment $comment)
    {
        return $user->id === $comment->user_id;
    }
}
