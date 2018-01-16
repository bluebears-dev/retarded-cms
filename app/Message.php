<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Message extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'author', 'content'
    ];

    protected $table = 'messages';

    public static function fetch(int $skip, int $amount)
    {
        return DB::table('messages')
            ->latest()
            ->offset($skip)
            ->limit($amount)
            ->get();
    }
}
