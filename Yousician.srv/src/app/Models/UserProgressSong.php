<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProgressSong extends Model
{
    protected $table = 'users_progress_songs';

    public $timestamps = false;

    /**
     * The attributes that should be hidden for arrays.
     */
    protected $hidden = ['id', 'user_id', 'instrument', 'version',];

    protected $fillable = [
        'user_id', 'song_id', 'data', 'instrument', 'version',
    ];

}