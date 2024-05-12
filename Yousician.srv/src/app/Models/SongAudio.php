<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class SongAudio extends Model
{
    protected $table = 'song_audios';

    public $timestamps = false;

    /**
     * The attributes that should be hidden for arrays.
     */
    protected $hidden = ['id', 'song_id'];

    protected $fillable = [
        'song_id', 'url', 'key', 'original_file_name', '_id', 'type', 'name',
    ];

    protected function url(): Attribute
    {
        return Attribute::make(
//            get: fn(string $value) => base_url() . str_replace('.ogg', '', $value),
            get: fn(string $value) => assets($value),
        );
    }

}