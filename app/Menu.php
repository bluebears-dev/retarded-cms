<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'entry', 'page'
    ];

    protected $table = 'menus';

    public static function fetch($page) {
        return Page::where('name', $page)->get(['route'])->first()->route;
    }
}
