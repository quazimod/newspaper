<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'post_id'
    ];

    /**
     * Get the post of the like.
     */
    public function post()
    {
        return $this->belongsTo('App\Post');
    }

    /**
     * Get the user of the like.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
