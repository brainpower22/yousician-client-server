<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class SongExercise extends Model
{
    protected $table = 'song_exercise';

    public $timestamps = false;

    /**
     * The attributes that should be hidden for arrays.
     */
    protected $hidden = ['id', 'song_id'];

    protected $fillable = [
        'song_id', 'type', 'file_id', 'metadata',
    ];

    protected $casts = [
        'public' => 'boolean',
        'is_licensed' => 'boolean',
        'preview' => 'boolean',
        'hidden' => 'boolean',
        'is_clear_premium' => 'boolean',
    ];

    protected function metadata(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => $this->adaptMetadata($value),
        );
    }

    public function adaptMetadata($data)
    {
        $data = json_decode($data, true);
        if (isset($data['annotation_texts'])) {
            $data['annotation_texts'] = (object)$data['annotation_texts'];
        }
        return $data;
    }

}