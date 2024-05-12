<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SongGenre extends Model
{
    protected $table = 'song_genres';

    public $timestamps = false;

    /**
     * The attributes that should be hidden for arrays.
     */
    protected $hidden = ['song_id'];

    protected $fillable = [
        'song_id', 'genre',
    ];

}