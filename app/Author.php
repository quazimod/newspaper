<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

/**
 * @method static Builder where($column, $operator = null, $value = null, $boolean = 'and')
 */
class Author extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'url'
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'description' => 'some description here',
    ];

    /**
     * Get the posts for the author.
     */
    public function posts()
    {
        return $this->hasMany('App\Post');
    }
}
