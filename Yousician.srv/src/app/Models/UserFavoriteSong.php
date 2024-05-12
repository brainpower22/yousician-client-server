<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserFavoriteSong extends Model
{
    protected $table = 'users_favorite_songs';

    public $timestamps = false;

    /**
     * The attributes that should be hidden for arrays.
     */
    protected $hidden = ['id', 'user_id', 'instrument', 'syllabus'];

    protected $fillable = [
        'user_id', 'song_id', 'instrument', 'syllabus',
    ];

}