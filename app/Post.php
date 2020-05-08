<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'content', 'image_url', 'source_url', 'author_id'
    ];

    /**
     * Get the author of the post.
     */
    public function author()
    {
        return $this->belongsTo('App\Author');
    }

    /**
     * Get the comments for the post.
     */
    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    /**
     * Get the likes for the post.
     */
    public function likes()
    {
        return $this->hasMany('App\Like');
    }

}
