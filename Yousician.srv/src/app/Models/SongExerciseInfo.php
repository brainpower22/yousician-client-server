<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SongExerciseInfo extends Model
{
    protected $table = 'song_exercise_info';

    public $timestamps = false;

    /**
     * The attributes that should be hidden for arrays.
     */
    protected $hidden = ['id', 'song_id'];

    protected $fillable = [
        'song_id', 'description',
    ];

}