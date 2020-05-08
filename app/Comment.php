<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'text', 'user_id', 'post_id', 'user_comment_id'
    ];



    /**
     * Get the post of the comment.
     */
    public function post()
    {
        return $this->belongsTo('App\Post');
    }

    /**
     * Get the user of the comment.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

}
