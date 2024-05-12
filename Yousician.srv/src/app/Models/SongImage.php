<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class SongImage extends Model
{
    protected $table = 'song_images';

    public $timestamps = false;

    /**
     * The attributes that should be hidden for arrays.
     */
    protected $hidden = ['id', 'song_id'];

    protected $fillable = [
        'song_id', 'type', 'url', 'key', 'original_file_name',
    ];

    protected function url(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => assets($value),
        );
    }

}