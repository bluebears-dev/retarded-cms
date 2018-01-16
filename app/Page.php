<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    /**
     *
     * Default value for attributes.
     *
     * @var array
     *
     */

    protected $attributes = array(
        'template' => 'default',
        'published' => true
    );

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'parent_page', 'content', 'published'
    ];

    protected $table = 'pages';
}
