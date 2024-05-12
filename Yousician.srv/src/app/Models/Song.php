<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    protected $table = 'songs';

    public $timestamps = false;

    /**
     * The attributes that should be hidden for arrays.
     */
    protected $hidden = ['id', 'locale', 'stage'];

    protected $fillable = [
        'id', 'locale', '_id', 'doc_id', 'owner', 'level', 'artist', 'public', 'is_licensed', 'instrument', 'complexity',
        'name', 'original_publish_date', 'search', 'composers', 'published_on', 'play_count', 'type', 'song', 'track_id',
        'arrangement', 'alignment', 'preview', 'hidden', 'title', 'part_count', 'artist_id', 'version', 'is_clear_premium', 'stage',
        'playable_parts',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_licensed' => 'boolean',
        'is_clear_premium' => 'boolean',
        'hidden' => 'boolean',
        'preview' => 'boolean',
        'public' => 'boolean',
        'playable_parts' => 'array',
        'alignment' => 'array',
    ];

    public function audios()
    {
        return $this->hasMany(SongAudio::class);
    }
    public function videos()
    {
        return $this->hasMany(SongVideo::class);
    }

    public function exercise()
    {
        return $this->hasOne(SongExercise::class);
    }

    public function derived_tags()
    {
        return $this->hasMany(SongDerivedTag::class);
    }

    public function tags()
    {
        return $this->hasMany(SongTag::class);
    }

    public function images()
    {
        return $this->hasMany(SongImage::class);
    }

    public function meta()
    {
        return $this->hasOne(SongMeta::class);
    }

    public function genres()
    {
        return $this->hasMany(SongGenre::class);
    }

    public function exercise_info()
    {
        return $this->hasOne(SongExerciseInfo::class);
    }

}