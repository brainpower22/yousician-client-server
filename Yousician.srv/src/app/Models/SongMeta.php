<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SongMeta extends Model
{
    protected $table = 'song_meta';

    public $timestamps = false;

    /**
     * The attributes that should be hidden for arrays.
     */
    protected $hidden = ['id', 'song_id'];

    protected $fillable = [
        'song_id', 'simplePlayCount', 'avgRating', 'ratingsCount', 'preview_video_processing_requested', 'preview_video_processing_failure',
    ];

    protected $casts = [
        'preview_video_processing_requested' => 'boolean',
    ];

}