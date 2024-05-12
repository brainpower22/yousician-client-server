<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class SongVideo extends Model
{
    protected $table = 'song_videos';

    public $timestamps = false;

    /**
     * The attributes that should be hidden for arrays.
     */
    protected $hidden = ['id', 'song_id'];

    protected $fillable = [
        'song_id', 'img_id', 'file_id', 'url', 'img_url',
    ];

    protected function url(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => assets($value),
        );
    }

}